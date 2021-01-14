<?php
class Camions{
    // Connexion
    private $connexion;
    private $table = "Camion";

    // object properties
    public $id_camion;
    public $positionX_camion;
    public $positionY_camion;
    public $immatriculation;
    public $capacite;
	public $id_feu;
	public $id_caserne;

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
	
		
	 /**
     * Créer un camion
     *
     * @return void
     */
	public function creer(){
		
		// On écrit la requête
        $sql = "SELECT id_caserne FROM Caserne where nom=:nom";

        // On prépare la requête
        $query1 = $this->connexion->prepare($sql);
		
		$query1->bindParam(":nom", strtoupper($this->nom_caserne));

        // On exécute la requête
        $query1->execute();
		
		$row = $query1->fetch(PDO::FETCH_ASSOC);

		$this->id_caserne = $row['id_caserne'];
		
		if($this->id_caserne != ""){
			$sql = "INSERT INTO " . $this->table . " SET positionX_camion = :positionX_camion, positionY_camion = :positionY_camion, immatriculation=:immatriculation, capacite=:capacite, id_caserne=:id_caserne";

			$query = $this->connexion->prepare($sql);

			 // Protection contre les injections
			$this->positionX_camion=htmlspecialchars(strip_tags($this->positionX_camion));
			$this->positionY_camion=htmlspecialchars(strip_tags($this->positionY_camion));
			$this->immatriculation=htmlspecialchars(strip_tags($this->immatriculation));
			$this->capacite=htmlspecialchars(strip_tags($this->capacite));
			$this->id_caserne=htmlspecialchars(strip_tags($this->id_caserne));

			// Ajout des données protégées
			$query->bindParam(":positionX_camion", $this->positionX_camion);
			$query->bindParam(":positionY_camion", $this->positionY_camion);
			$query->bindParam(":immatriculation", $this->immatriculation);
			$query->bindParam(":capacite", $this->capacite);
			$query->bindParam(":id_caserne", $this->id_caserne);

			// Exécution de la requête
			if($query->execute()){
				return true;
			}
			return false;
		}
    }
	

    /**
     * Assigner un camion à un feu
     *
     * @return void
     */
    public function assigner_camion_a_un_feu(){
		// On écrit la requête
        $sql = "SELECT * FROM Position where positionX=:positionX and positionY=:positionY";

        // On prépare la requête
        $query1 = $this->connexion->prepare($sql);
		
		$query1->bindParam(":positionX", $this->posX);
        $query1->bindParam(":positionY", $this->posY);

        // On exécute la requête
        $query1->execute();
		
		$r = $query1->fetch(PDO::FETCH_ASSOC);
		// On hydrate l'objet
		$id_position = $r['id_position'];
		$positionX = $r['positionX'];
		$positionY = $r['positionY'];

		
		if (!empty($id_position)){
			$sql = "SELECT id_feu FROM Feu where id_position=:id_position";

			// On prépare la requête
			$query1 = $this->connexion->prepare($sql);
			
			$query1->bindParam(":id_position", $id_position);

			// On exécute la requête
			$query1->execute();
			
			$r = $query1->fetch(PDO::FETCH_ASSOC);
			// On hydrate l'objet
			$this->id_feu = $r['id_feu'];
			
			if (!empty($this->id_feu)){
				 // On écrit la requête
				$sql = "UPDATE " . $this->table . ' SET id_feu = :id_feu, positionX_camion=:positionX_camion, positionY_camion=:positionX_camion WHERE immatriculation = :immatriculation';
				
				// On prépare la requête
				$query = $this->connexion->prepare($sql);
				
				// On sécurise les données
				$this->id_feu=htmlspecialchars(strip_tags($this->id_feu));
				$this->positionX_camion=htmlspecialchars(strip_tags($positionX));
				$this->positionY_camion=htmlspecialchars(strip_tags($positionY));
				$this->immatriculation=htmlspecialchars(strip_tags($this->immatriculation));

				
				// On attache les variables
				$query->bindParam(':id_feu', $this->id_feu);
				$query->bindParam(':positionX_camion', $this->positionX_camion);
				$query->bindParam(':positionY_camion', $this->positionY_camion);
				$query->bindParam(':immatriculation', $this->immatriculation);
				
				
				// On exécute
				if($query->execute()){
					return true;
				}
				
				return false;				
			}
		}
    }
	
	
	public function modifier_id_feu(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET id_feu = :id_feu WHERE id_camion = :id_camion";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->id_feu=htmlspecialchars(strip_tags($this->id_feu));
		$this->id_camion=htmlspecialchars(strip_tags($this->id_camion));
        
        // On attache les variables
        $query->bindParam(':id_feu', $this->id_feu);
        $query->bindParam(':id_camion', $this->id_camion);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
	
	
	public function modifier_position(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET positionX_camion = :positionX_camion, positionY_camion = :positionY_camion WHERE id_camion = :id_camion";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->positionX_camion=htmlspecialchars(strip_tags($this->positionX_camion));
        $this->positionY_camion=htmlspecialchars(strip_tags($this->positionY_camion));
		$this->id_camion=htmlspecialchars(strip_tags($this->id_camion));
        
        // On attache les variables
        $query->bindParam(':id_camion', $this->id_camion);
        $query->bindParam(':positionX_camion', $this->positionX_camion);
        $query->bindParam(':positionY_camion', $this->positionY_camion);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}