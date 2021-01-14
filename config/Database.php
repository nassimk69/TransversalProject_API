<?php
class Database{
    // Connexion à la base de données
    private $host = "xxxxxxxxxx";
    private $db_name = "xxxxxxxxx";
    private $username = "root";
    private $password = "hahahatucroyaisavoirlemdp?";
    public $connexion;

    // getter pour la connexion
    public function getConnection(){

        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
}
