<?php
require_once 'DBconfig.php';
require_once 'core/Database.php';

class DBAdministrator extends Database {

    /**
     * editUser
     * edits email and/or administrator privileges for an user
     * @param  string $id
     * @param  string $email
     * @param  string $admin
     * @return mixed success message or failure messages
     */
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

        // verify the email is an email, is not too long to be stocked and it is not already used
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if($email === false) {
            $errorMessage[] = 'Le nom n\'est pas valable.';
        } elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errorMessage[] = 'L\'email n\'est pas valable.';
        } elseif(strlen($email) > 50) {
            $errorMessage[] = 'L\'email est trop long.';
        } else {
            $exists = $this->dbConnection->prepare('SELECT * FROM users WHERE email = :email AND id != :id');
            $exists->execute(array('email' => $email, 'id' => $id));
            if($exists->fetch()) {
                $errorMessage[] = 'Cet email est déjà relié à un autre compte';
            }
        }

        // if there are no errors add modifs to database
        if(count($errorMessage) === 0) {
            $req = $this->dbConnection->prepare('UPDATE users SET email = :email, admin = :admin WHERE id = :id');
            try {
                $req->execute(array('email' => $email, 'admin' => $admin, 'id' => $id));
                return "success";
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            }
        } else {
            return $errorMessage;
        }
    }
    
    /**
     * verifyProductInput
     *  sanitizes and verifies input for new product or input updates for existing one
     * 
     * @param  mixed $id
     * @param  string $name
     * @param  string $description
     * @param  string $price
     * @param  array $img
     * @param  string $category_id
     * @return mixed
     */
    public function verifyProductInput($id, $name, $description, $price, $img, $category_id) {
        // if id given (product modification) sanitize id and verify the product exists
        if(!is_null($id)) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if($id === false) {
                return NULL;
            } elseif(!$this->getProduct($id)) {
                return NULL;
            }
        }
        
        // sanitize name and check length
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        if($name === false) {
            $errorMessage[] = 'Le nom n\'est pas valable.';
        } elseif(strlen($name) > 255) {
            $errorMessage[] = 'Le nom est trop long.';
        }

        //sanitize description
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        if($description === false) {
            $errorMessage[] = 'La description n\'est pas valable.';
        }

        // verify price is a number and positive
        $price = floatval(filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        if($price === false || (!is_numeric($price) && $price <= 0)) {
            $errorMessage[] = 'Le prix n\'est pas valable';
        }

        // if id given, checks if the image was changed
        if (!is_null($id) && empty($img['name'])) {
            $productImg = 'unchanged';
        } else {
        // verify image file type and size are valid and transfer it if ok
            $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
            $imgType = exif_imagetype($img['tmp_name']);
            $maxImgSize = 300 * 1024;
            if(in_array($imgType, $allowedTypes)) {
                if($img['size'] < $maxImgSize) {
                    switch($imgType) {
                        case IMAGETYPE_GIF :
                            $ext = '.gif';
                            break;
                        case IMAGETYPE_JPEG :
                            $ext = '.jpeg';
                            break;
                        case IMAGETYPE_PNG :
                            $ext = '.png';
                            break;
                    }
                    $destFolder = 'products/img/';
                    $destFile = date('d-m-y-H-i-s') . $ext;
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
        }

        // sanitize parent id and check existence, if no parent id_parent is null
        $category_id = filter_var($category_id, FILTER_SANITIZE_NUMBER_INT);
        if($category_id === false) {
            $errorMessage[] = 'La catégorie parente n\'est pas valable.';
        } elseif(!$this->getCategory($category_id)) {
            $errorMessage[] = 'La catégorie parente n\'existe pas.';
        }

        if(count($errorMessage) === 0) {
            // if no errors return sanitized parameters
            return ['status' => 'success', 'id' => $id, 'name' => $name, 'description' => $description, 'price' => $price, 'img' => $productImg, 'category_id' => $category_id];
        } else {
            // if error return the error messages
            return ['status' =>'fail', 'message' => $errorMessage];
        }
    }
    
    /**
     * deleteProductImg
     * deletes the product image associated to the id from the stockage folder
     * @param  string $id
     * @return string success or failure message
     */
    public function deleteProductImg($id) {
        $product = $this->getProduct($id);
        if (unlink($product['img'])) {
            return 'L\'ancienne image a été supprimée du dossier de stockage.';
        } else {
            return 'L\'ancienne image n\'a pas pu être effacée du dossier de stockage.';
        }
    }
    
    /**
     * editProduct
     * edits an existing product's infos on database
     * @param  string $id
     * @param  string $name
     * @param  string $description
     * @param  string $price
     * @param  array $img
     * @param  string $category_id
     * @return mixed
     */
    public function editProduct($id, $name, $description, $price, $img, $category_id) {
        // sanitize and verify input
        $resultVerif = $this->verifyProductInput($id, $name, $description, $price, $img, $category_id);

        if (is_null($resultVerif)) {
            return 'wrongid'; // returns wrongid if the given id was not valid
        } elseif($resultVerif['status'] === 'success' && $resultVerif['img'] !== 'unchanged') {
        // if parameters passed all the tests with no errors and new img was uploaded add the product modifs to DB
        // first delete the old image
            $deleteOldImg = $this->deleteProductImg($resultVerif['id']);
            $req = $this->dbConnection->prepare('UPDATE products SET
                    name = :name, description = :description, price = :price, img = :img, category_id = :category_id
                    WHERE id = :id');
            try {
                $addedProduct = $req->execute(array('name' =>$resultVerif['name'], 
                                                'description' => $resultVerif['description'], 
                                                'price' => $resultVerif['price'], 
                                                'img' => $resultVerif['img'],
                                                'category_id' => $resultVerif['category_id'],
                                                'id' => $resultVerif['id']));
                return ['status' => 'success', 'message' => $deleteOldImg];
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            }
        } elseif($resultVerif['status'] === 'success' && $resultVerif['img'] === 'unchanged') {
            // if parameters passed all the tests with no errors add the product modifs to DB
            $req = $this->dbConnection->prepare('UPDATE products SET
                    name = :name, description = :description, price = :price, category_id = :category_id
                    WHERE id = :id');
            try {
                $addedProduct = $req->execute(array('name' =>$resultVerif['name'], 
                                                'description' => $resultVerif['description'], 
                                                'price' => $resultVerif['price'],
                                                'category_id' => $resultVerif['category_id'],
                                                'id' => $resultVerif['id']));
                return ['status' => 'success'];
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            } 
        } else {
            return ['status' => 'fail', 'errorMessage' => $resultVerif['message']];
        }
    }
    
    /**
     * addProduct
     * adds a new product to database
     * @param  string $name
     * @param  string $description
     * @param  string $price
     * @param  array $img
     * @param  string $category_id
     * @return mixed success message or array of error message(s)
     */
    public function addProduct($name, $description, $price, $img, $category_id) {
        // sanitize and verify input
        $resultVerif = $this->verifyProductInput(NULL, $name, $description, $price, $img, $category_id);

        // if parameters passed all the tests with no errors add the product to DB
        if($resultVerif['status'] === 'success') {
            $req = $this->dbConnection->prepare('INSERT INTO products (name, description, price, img, category_id)
                    VALUES (:name, :description, :price, :img, :category_id)');
            try {
                $addedProduct = $req->execute(array('name' =>$resultVerif['name'], 
                                                'description' => $resultVerif['description'], 
                                                'price' => $resultVerif['price'], 
                                                'category_id' => $resultVerif['category_id'], 
                                                'img' => $resultVerif['img']));
                return 'success';
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            }
        } elseif ($resultVerif['status'] === 'fail') {
            return $resultVerif['message'];
        }
    }
    
    /**
     * verifyCategoryInput
     *
     * @param  string $id
     * @param  string $name
     * @param  string $parent_id
     * @return mixed null if wrong id, or array with status and error messages if failure, sanitized parameters if success
     */
    public function verifyCategoryInput($id, $name, $parent_id) {
        // if id given (category modification) sanitize id and verify the category exists
        if(!is_null($id)) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if($id === false) {
                return NULL;
            } elseif(!$this->getCategory($id)) {
                return NULL;
            }
        }

        // sanitize name, check length and existence to avoid duplicates
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        if($name === false) {
            $errorMessage[] = 'Le nom n\'est pas valable.';
        } elseif(strlen($name) > 255) {
            $errorMessage[] = 'Le nom est trop long.';
        } elseif(!is_null($id)) {
            $exists = $this->dbConnection->prepare('SELECT * FROM categories WHERE name = :name AND id != :id');
            $exists->execute(array('name' => $name, 'id' => $id));
            if($exists->fetch()) {
                $errorMessage[] = 'Une catégorie du même nom existe déjà.';
            }
        }

        // sanitize parent id and check existence, if no parent id_parent is null
        if($parent_id === 'NULL') {
            $parent_id = NULL;
        } else {
            $parent_id = filter_var($parent_id, FILTER_SANITIZE_NUMBER_INT);
            if($parent_id === false) {
                $errorMessage[] = 'La catégorie parente n\'est pas valable.';
            } elseif(!$this->getCategory($parent_id)) {
                $errorMessage[] = 'La catégorie parente n\'existe pas.';
            } elseif(!is_null($id) && $parent_id === $id) {
                $errorMessage[] = 'Une catégorie ne peut pas être sa propre parente.';
            }
        }

        if(count($errorMessage) === 0) {
            // if no errors return sanitized parameters
            return ['status' => 'success', 'id' => $id, 'name' => $name, 'parent_id' => $parent_id];
        } else {
            // if error return the error messages
            return ['status' =>'fail', 'message' => $errorMessage];
        }
    }
    
    /**
     * addCategory
     *
     * @param  string $name
     * @param  string $parent_id
     * @return mixed success message or array of error messages
     */
    public function addCategory($name, $parent_id) {
                // sanitize and verify input
                $resultVerif = $this->verifyCategoryInput(NULL, $name, $parent_id);

                // if parameters passed all the tests with no errors add the category to DB
                if($resultVerif['status'] === 'success') {
                    $req = $this->dbConnection->prepare('INSERT INTO categories (name, parent_id) VALUES (:name, :parent_id)');
                    try {
                        $addedCategory = $req->execute(array('name' =>$resultVerif['name'], 'parent_id' => $resultVerif['parent_id']));
                        return 'success';
                    }
                    catch (Exception $e) {
                        error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                        echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
                    }
                } elseif ($resultVerif['status'] === 'fail') {
                    return $resultVerif['message'];
                }
    }
    
    /**
     * editCategory
     *
     * @param  string $id
     * @param  string $name
     * @param  string $parent_id
     * @return mixed wrong id message if invalid id, success message, or array of error messages
     */
    public function editCategory($id, $name, $parent_id) {
        // sanitize and verify input
        $resultVerif = $this->verifyCategoryInput($id, $name, $parent_id);

        if (is_null($resultVerif)) {
            return 'wrongid'; // returns wrongid if the given id was not valid
        } elseif($resultVerif['status'] === 'success') {
            // if parameters passed all the tests with no errors add the category modifs to DB
            $req = $this->dbConnection->prepare(('UPDATE categories 
                                        SET name = :name, parent_id = :parent_id WHERE id = :id'));
            try {
                $addedCategory = $req->execute(array('name' =>$resultVerif['name'], 
                                                    'parent_id' => $resultVerif['parent_id'],
                                                    'id' => $resultVerif['id']));
                return 'success';
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            }
        } elseif ($resultVerif['status'] === 'fail') {
            return $resultVerif['message'];
        }
    }


    /**
     * deleteUser
     * delete an user if id exists
     * @param  string $id
     * @return array success or failure status and message
     */
    public function deleteUser($id) {
        try {
            if($this->getUser($id) !== false) {
                $req = $this->dbConnection->prepare('DELETE FROM users WHERE id = ?');
                $req->execute(array($id));
                $result =  ['status' => 'success', 'message' => "L'utilisateur #" . $id . " a bien été supprimé."];
            } else {
                $result = ['status' => 'fail', 'message' => "L'utilisateur #" . $id . " n'existe pas."];
            }
            return $result;
        }
        catch (Exception $e) {
            error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
            echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
        }
    }
    
    /**
     * deleteProduct
     * delete a product if id exists
     * @param  string $id
     * @return array success or failure status and message
     */
    public function deleteProduct($id) {
        try {
            if($this->getProduct($id) !== false) {
                $deleteImg = $this->deleteProductImg($id);
                $req = $this->dbConnection->prepare('DELETE FROM products WHERE id = ?');
                $req->execute(array($id));
                $result =  ['status' => 'success', 'message' => "Le produit #" . $id . " a bien été supprimé.", 'imgMessage' => $deleteImg];
            } else {
                $result = ['status' => 'fail', 'message' => "Le produit #" . $id . " n'existe pas."];
            }
            return $result;
        }
        catch (Exception $e) {
            error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
            echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
        }
    }
}