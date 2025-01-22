<?php
class Dbh {
    private $host = "localhost";
    private $dbname = "task-manager";
    private $dbusername = "root";
    private $dbpassword = "";
    private $bdd;

    

    public function connect() {
        try {
            $this->bdd = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4", $this->dbusername, $this->dbpassword);
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->bdd;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        if (!isset($this->bdd)) {
            $this->bdd = $this->connect();
        }
        return $this->bdd;
    }
}
?>