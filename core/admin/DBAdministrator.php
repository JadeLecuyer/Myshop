<?php

class DBAdministrator {
    private $dbUser;
    private $dbPassword;
    private $dsn;
    private $dbConnection = NULL;
    private $errorLogFile;

    private $currentUser = NULL;
    private $userConnected = false;

    private static $firstConnexion = 0;

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
            if(self::$firstConnexion < 1) {
                $this->setUpDatabase();
                self::$firstConnexion ++;
            }
        } 
        catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
            echo 'PDO ERROR: ' . $e->getMessage() . ', storage in ' . $this->errorLogFile . "\n";
        }
        return $this;
    }
    
    /**
     * setUpDatabase
     * add necessary columns to db if they don't exist
     * columns img and description for products
     * @return void
     */
    public function setUpDatabase() {
        $req = $this->dbConnection->query('DESCRIBE products');
        $columns = $req->fetchAll(PDO::FETCH_COLUMN, 0);
        if (!in_array('description', $columns)) {
            $this->dbConnection->query('ALTER TABLE products ADD description TEXT');
        }
        if (!in_array('img', $columns)) {
            $this->dbConnection->query('ALTER TABLE products ADD img VARCHAR(255)');
        }
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

    public function getUser($id) {
        $req = $this->dbConnection->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute(array($id));
        if($result = $req->fetch(PDO::FETCH_ASSOC)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getProduct($id) {
        $req = $this->dbConnection->prepare('SELECT * FROM products WHERE id = ?');
        $req->execute(array($id));
        if($result = $req->fetch(PDO::FETCH_ASSOC)) {
            return $result;
        } else {
            return false;
        }
    }

    public function editUser($id, $email, $admin) {
        // sanitize id and verify the user exists
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if($id === false) {
            return NULL;
        } elseif(!$this->getUser($id)) {
            return NULL;
        }

        // verify the admin value is valid
        if ($admin !== '1' && $admin !== '0') {
            $errorMessage[] = 'La valeur du champ administrateur n\'est pas valable.';
        }

        // verify the email is an email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if($email === false) {
            $errorMessage[] = 'Le nom n\'est pas valable.';
        } elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errorMessage[] = 'L\'email n\'est pas valable.';
        }

        // if there are no errors add modifs to database
        if(count($errorMessage) === 0) {
            $req = $this->dbConnection->prepare('UPDATE users SET email = :email, admin = :admin WHERE id = :id');
            try {
                $req->execute(array('email' =>$email, 'admin' => $admin, 'id' => $id));
                return "success";
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: ' . $e->getMessage() . ' storage in ' . $this->errorLogFile . "\n";
            }
        } else {
            return $errorMessage;
        }
    }

    public function verifyProductInput($id, $name, $description, $price, $img) {
        // if id given (product modification) sanitize id and verify the user exists
        if(!is_null($id)) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if($id === false) {
                return NULL;
            } elseif(!$this->getProduct($id)) {
                return NULL;
            }
        }
        
        // sanitize name
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        if($name === false) {
            $errorMessage[] = 'Le nom n\'est pas valable.';
        }

        //sanitize description
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        if($description === false) {
            $errorMessage[] = 'La description n\'est pas valable.';
        }

        // verify price is a number and positive
        if(!is_numeric($price) && $price <= 0) {
            $errorMessage[] = 'Le prix n\'est pas valable';
        }

        // if id given checks if the image was
        
        // verify image file type and size is valid and transfers it if ok
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
        $imgType = exif_imagetype($img['tmp_name']);
        $maxImgSize = 100 * 1024;
        if(in_array($imgType, $allowedTypes)) {
            if($img['size'] < $maxImgSize) {
                $destFolder = '/assets/img/products/';
                $destFile = date('d.m.y.H.i.s');
                while (file_exists($destFolder . $destFile)) {
                    $destFile = rand() . $destFile;
                }
                if (move_uploaded_file($img['tmp_name'], $destFolder . $destFile)){
                    $productImg = $destFolder . $destFile;
                } else {
                    $errorMessage[] = 'Erreur lors du transfert du fichier';
                }
            } else {
                $errorMessage[] = 'L\'image est trop lourde.';
            }
        } else {
            $errorMessage[] = 'Veuillez soumettre un fichier image de type jpeg, png ou gif.';
        }

        if(count($errorMessage) === 0) {
            // if no errors return sanitized parameters
            return ['status' => 'success', 'id' => $id, 'name' => $name, 'description' => $description, 'price' => $price, 'img' => $productImg];
        } else {
            // if error return the error messages
            return ['status' =>'fail', 'message' => $errorMessage];
        }
    }

    public function editProduct($id, $name, $description, $price, $img) {
        // sanitize and verify input
        $resultVerif = $this->verifyProductInput($id, $name, $description, $price, $img);

        if (is_null($resultVerif)) {
            return NULL; // returns null if the given id was not valid
        } elseif($resultVerif['status'] === 'success') {
        // if paramaters passed all the tests with no errors add the product modifs to DB
            $req = $this->dbConnection->prepare('UPDATE products SET
                    name = :name, description = :description, price = :price, img = :img
                    WHERE id = :id');
            try {
                $addedProduct = $req->execute(array('name' =>$resultVerif['name'], 
                                                'description' => $resultVerif['description'], 
                                                'price' => $resultVerif['price'], 
                                                'img' => $resultVerif['img'],
                                                'id' => $resultVerif['id']));
                return 'success';
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: ' . $e->getMessage() . ' storage in ' . $this->errorLogFile . "\n";
            }
        } else {
            return $resultVerif['message'];
        }
    }

    public function addProduct($name, $description, $price, $img) {
        // sanitize and verify input
        $resultVerif = $this->verifyProductInput(NULL, $name, $description, $price, $img);

        // if paramaters passed all the tests with no errors add the product to DB
        if($resultVerif['status'] === 'success') {
            $req = $this->dbConnection->prepare('INSERT INTO products (name, description, price, img)
                    VALUES (:name, :description, :price, :img)');
            try {
                $addedProduct = $req->execute(array('name' =>$resultVerif['name'], 
                                                'description' => $resultVerif['description'], 
                                                'price' => $resultVerif['price'], 
                                                'img' => $resultVerif['img']));
                return 'success';
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: ' . $e->getMessage() . ' storage in ' . $this->errorLogFile . "\n";
            }
        } else {
            return $resultVerif['message'];
        }
    }
    
    /**
     * deleteUser
     * delete an user if id exists
     * @param  string $id
     * @return void
     */
    public function deleteUser($id) {
        try {
            if($this->getUser($id) !== false) {
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
    
    /**
     * deleteProduct
     * delete a product if id exists
     * @param  string $id
     * @return void
     */
    public function deleteProduct($id) {
        try {
            if($this->getProduct($id) !== false) {
                $req = $this->dbConnection->prepare('DELETE FROM products WHERE id = ?');
                $req->execute(array($id));
                return "Le produit #" . $id . " a bien été supprimé.";
            } else {
                return "Le produit #" . $id . " n'existe pas.";
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}