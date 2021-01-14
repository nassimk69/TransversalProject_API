<?php
class Casernes{
    // Connexion
    private $connexion;
    private $table = "Caserne";

    // object properties
    public $id_caserne;
	public $nom;
    public $positionX_caserne;
    public $positionY_caserne;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des casernes
     *
     * @return void
     */
    public function lire(){
        // On écrit la requête
        $sql = "SELECT * FROM Caserne";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }
	
		
	 /**
     * Créer une caserne
     *
     * @return void
     */
	public function creer(){
        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, positionX_caserne=:positionX_caserne, positionY_caserne=:positionY_caserne";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->positionX_caserne=htmlspecialchars(strip_tags($this->positionX_caserne));
        $this->positionY_caserne=htmlspecialchars(strip_tags($this->positionY_caserne));

        // Ajout des données protégées
        $query->bindParam(":nom", $this->nom);
        $query->bindParam(":positionX_caserne", $this->positionX_caserne);
        $query->bindParam(":positionY_caserne", $this->positionY_caserne);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }
	

   
}