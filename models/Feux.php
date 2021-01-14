<?php
class Feux{
    // Connexion
    private $connexion;
    private $table = "Feu";

    // object properties
    public $id_feu;
    public $id_position;
    public $intensite;
    public $date_debut;
    public $date_fin;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des feux
     *
     * @return void
     */
    public function lire(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table;

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }
	
	public function lire2(){
        // On écrit la requête
        $sql = "SELECT f.id_feu, f.intensite, p.positionX, p.positionY, p.id_position FROM Feu f left join Position p ON f.id_position = p.id_position ";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }
	
	public function lireUn(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table . " WHERE id_feu = ?";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On attache l'id
        $query->bindParam(1, $this->id_feu);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->id_feu = $row['id_feu'];
        $this->intensite = $row['intensite'];
        $this->date_debut = $row['date_debut'];
        $this->date_fin = $row['date_fin'];
        $this->id_position = $row['id_position'];
    }
	
	
	 /**
     * Créer un feu
     *
     * @return void
     */
	public function creer(){
		
		// On écrit la requête
        $sql = "SELECT id_position FROM Position where positionX=:positionX and positionY=:positionY";

        // On prépare la requête
        $query1 = $this->connexion->prepare($sql);
		
		$query1->bindParam(":positionX", $this->posX);
        $query1->bindParam(":positionY", $this->posY);

        // On exécute la requête
        $query1->execute();
		
		$r = $query1->fetch(PDO::FETCH_ASSOC);
		// On hydrate l'objet
		$this->id_position = $r['id_position'];
		
		if ($query1->fetchColumn() < 1){			
			$sql = "INSERT INTO Position SET positionX=:positionX, positionY=:positionY";
			$query = $this->connexion->prepare($sql);

			// Protection contre les injections
			$this->posX=htmlspecialchars(strip_tags($this->posX));
			$this->posY=htmlspecialchars(strip_tags($this->posY));
			
			$this->posX = floatval($this->posX);
			$this->posX = round($this->posX, 2);
			$this->posX = strval($this->posX);
			
			$this->posY = floatval($this->posY);
			$this->posY = round($this->posY, 2);
			$this->posY = strval($this->posY);

			// Ajout des données protégées
			$query->bindParam(":positionX", $this->posX);
			$query->bindParam(":positionY", $this->posY);

			// Exécution de la requête
			if($query->execute()){
				 $sql = "SELECT id_position FROM Position where positionX=:positionX and positionY=:positionY";

				$query = $this->connexion->prepare($sql);
				
				$query->bindParam(":positionX", $this->posX);
				$query->bindParam(":positionY", $this->posY);

				$query->execute();
				
				$row = $query->fetch(PDO::FETCH_ASSOC);

				$this->id_position = $row['id_position'];
			}

		} 

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET intensite=:intensite, date_debut=:date_debut, id_position=:id_position";

        $query = $this->connexion->prepare($sql);

         // Protection contre les injections
        $this->intensite=htmlspecialchars(strip_tags($this->intensite));
        $this->date_debut=htmlspecialchars(strip_tags($this->date_debut));

        // Ajout des données protégées
        $query->bindParam(":intensite", $this->intensite);
        $query->bindParam(":date_debut", $this->date_debut);
        $query->bindParam(":id_position", $this->id_position);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }
	

    /**
     * Eteindre un feu
     *
     * @return void
     */
    public function fin(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . ' SET date_fin = :date_fin, intensite = "0" WHERE id_position = :id_position';
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
		$date_of_the_day = date("Y-m-d");
        $this->date_fin="$date_of_the_day";
        $this->id_position=htmlspecialchars(strip_tags($this->id_position));
        
        // On attache les variables
        $query->bindParam(':id_position', $this->id_position);
        $query->bindParam(':date_fin', $this->date_fin);
		
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
	
	public function finfinfin(){
        // On écrit la requête
        $sql = "DELETE from " . $this->table . ' WHERE id_position = :id_position';
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->id_position=htmlspecialchars(strip_tags($this->id_position));
        
        // On attache les variables
        $query->bindParam(':id_position', $this->id_position);
		
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour l'intensite d'un feu
     *
     * @return void
     */
    public function modifier_intensite(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . ' SET intensite = :intensite WHERE id_feu = :id_feu';
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->id_feu=htmlspecialchars(strip_tags($this->id_feu));
        $this->intensite=htmlspecialchars(strip_tags($this->intensite));
        
        // On attache les variables
		$query->bindParam(':id_feu', $this->id_feu);
        $query->bindParam(':intensite', $this->intensite);
		
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
	
	
	public function positionExist(){
        // On écrit la requête
        $sql = "SELECT id_position FROM Position WHERE positionX = '1' and positionY = '9'";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

}