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
    include_once '../models/Feux.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les feux
    $feu = new Feux($db);
	
    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->intensite) && !empty($donnees->date_debut) && !empty($donnees->posX) && !empty($donnees->posY)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $feu->intensite = $donnees->intensite;
        $feu->date_debut = $donnees->date_debut;
		$feu->posX = $donnees->posX;
		$feu->posY = $donnees->posY;
		
		echo json_encode(["message" => "juste loin: $feu->posY"]);

        if($feu->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "Le feu a été créé"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "Le feu n'a pas été créé: intensite: $feu->intensite , date debut: $feu->date_debut , posX: $feu->posX, posY: $feu->posY"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
