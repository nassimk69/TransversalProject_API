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
    include_once '../models/Casernes.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les casernes
    $caserne = new Casernes($db);
	
    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->nom_caserne) && !empty($donnees->posX) && !empty($donnees->posY)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $caserne->nom = strtoupper($donnees->nom_caserne);
        $caserne->positionX_caserne = $donnees->posX;
        $caserne->positionY_caserne = $donnees->posY;

        if($caserne->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "La caserne a été créée"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La caserne n'a pas été créée"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
