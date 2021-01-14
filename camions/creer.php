<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
    
    if(!empty($donnees->positionX_camion) && !empty($donnees->positionY_camion) && !empty($donnees->immatriculation) && !empty($donnees->capacite) && !empty($donnees->nom_caserne)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $camion->positionX_camion = $donnees->positionX_camion;
        $camion->positionY_camion = $donnees->positionY_camion;
        $camion->immatriculation = $donnees->immatriculation;
		$camion->capacite = $donnees->capacite;
		$camion->nom_caserne = $donnees->nom_caserne;

        if($camion->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "Le camion a été créé"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "Le camion n'a pas été créé: posX: $camion->positionX_camion , posY: $camion->positionY_camion, immat: $camion->immatriculation, capacite: $camion->capacite, nom caserne: $camion->nom_caserne"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
