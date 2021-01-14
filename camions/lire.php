<?php
// Headers requis
header("Access-Control-Allow-Origin: *"); //on pourra mettre notre URL ici
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Camions.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();
	
	

    // On instancie les feux
    $camion = new Camions($db);

    // On récupère les données
    $stmt = $camion->lire();

    // On vérifie si on a au moins 1 feu
    if($stmt->rowCount() > 0){
        // On initialise un tableau associatif
        $tableauCamions = [];
        $tableauCamions['camions'] = [];

        // On parcourt les camions
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $fe = [
                "id_camion" => $id_camion,
                "positionX_camion" => $positionX_camion,
                "positionY_camion" => $positionY_camion,
                "immatriculation" => $immatriculation,
                "capacite" => $capacite,
				"id_feu" => $id_feu,
				"id_caserne" => $id_caserne
            ];

            $tableauCamions['camions'][] = $fe;
        }

        // On envoie le code réponse 200 OK
        http_response_code(200);

        // On encode en json et on envoie
        echo json_encode($tableauCamions);
    }

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
