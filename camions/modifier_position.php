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
    
    if(!empty($donnees->posY) && !empty($donnees->posX) && !empty($donnees->id_camion)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $camion->positionY_camion = $donnees->posY;
		$camion->positionX_camion = $donnees->posX;
		$camion->id_camion = $donnees->id_camion;

        if($camion->modifier_position()){
            // Ici la modification a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La position du camion a été mise à jour"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La position du camion n'a pas été mise à jour"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
