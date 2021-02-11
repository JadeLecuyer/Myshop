<?php

class DBAdministrator {
    private $dbUser;
    private $dbPassword;
    private $dsn;
    private $dbConnection = NULL;
    private $errorLogFile;

    private $currentUser = NULL;
    private $userConnected = false;

    public function __construct() {
        $this->dbUser = 'root';
        $this->dbPassword = 'root';
        $this->dsn = "mysql:host=localhost;dbname=my_shop;port=3306;charset=UTF8";
        $this->errorLogFile = 'myShopErrors.log';
    }

    public function connect() {
        try {
            $connection = new PDO($this->dsn, $this->dbUser, $this->dbPassword);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConnection = $connection;
        } 
        catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
            echo 'PDO ERROR: ' . $e->getMessage() . ', storage in ' . $this->errorLogFile . "\n";
        }
        return $this;
    }

    public function getUsers() {
        $req = $this->dbConnection->prepare('SELECT * FROM users ORDER BY id');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts() {
        $req = $this->dbConnection->prepare('SELECT * FROM products ORDER BY id');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editUser() {}

    public function deleteUser($id) {
        try {
            $exists = $this->dbConnection->prepare('SELECT * FROM users WHERE id = ?');
            $exists->execute(array($id));
            if($exists->fetch()) {
                $req = $this->dbConnection->prepare('DELETE FROM users WHERE id = ?');
                $req->execute(array($id));
                $message = "L'utilisateur #" . $id . " a bien été supprimé.";
            } else {
                $message = "L'utilisateur #" . $id . " n'existe pas.";
            }
            return $message;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteProduct($id) {
        $exists = $this->dbConnection->prepare('SELECT * FROM products WHERE id = ?');
        $exists->execute(array($id));
        if($exists->fetch()) {
            $req = $this->dbConnection->prepare('DELETE FROM products WHERE id = ?');
            $req->execute(array($id));
            return "Le produit #" . $id . " a bien été supprimé.";
        } else {
            return "Le produit #" . $id . " n'existe pas.";
        }
    }
}