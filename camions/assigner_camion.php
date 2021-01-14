<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Camions.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les camions
    $camion = new Camions($db);

    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->positionX_feu) && !empty($donnees->positionY_feu) && !empty($donnees->immatriculation)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $camion->posX = $donnees->positionX_feu;
		$camion->posY = $donnees->positionY_feu;
		$camion->immatriculation = $donnees->immatriculation;

        if($camion->assigner_camion_a_un_feu()){
            // Ici la modification a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "Le camion a été assigné"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "Le camion n'a pas été assigné"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
