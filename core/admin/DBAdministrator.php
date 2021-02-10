<?php

class DBAdministrator {
    private $dbUser;
    private $dbPassword;
    private $dsn;
    private $dbConnection = NULL;
    private $errorLogFile;

    private $currentUser = NULL;
    private $userConnected = false;

    public function __construct($host, $dbuser, $dbpass, $dbport, $dbname) {
        $this->dbUser = $dbuser;
        $this->dbPassword = $dbpass;
        $this->dsn = "mysql:host=$host;dbname=$dbname;port=$dbport";
        $this->errorLogFile = $dbname . 'Errors.log';
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

    /*public function editUser() {}

    public function deluser($array) {
        if($this->currentUser['role'] == 'ADM') {
            if(count($array) !== 2) {
                echo  "Bad params. Usage: deluser id\n";
            } else {
                $exists = $this->dbConnection->prepare('SELECT name FROM users WHERE id = ?');
                $exists->execute(array($array[1]));
                if($exists->fetch()) {
                    $confirmation = readline("Are you sure ? [y/N]:");
                    if (strtolower($confirmation) == 'y') {
                        $req = $this->dbConnection->prepare('DELETE FROM users WHERE id = ?');
                        $req->execute(array($array[1]));
                    }
                } else {
                    echo "\t User #" . $array[1] . " unknown!\n";
                }
            }
        } else {
            echo "'" . $array[0] . "': Command unknown\n";
        }
    }*/
}