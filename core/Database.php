<?php
require 'DBconfig.php';

class Database {
    protected $dbUser;
    protected $dbPassword;
    protected $dsn;
    protected $dbConnection = NULL;
    protected $errorLogFile;

    protected $currentUser = NULL;
    protected $userConnected = false;

    protected static $firstConnexion = 0;

    public function __construct() {
        $this->dbUser = DB_USER;
        $this->dbPassword = DB_PASSWORD;
        $this->dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=UTF8';
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
            echo 'PDO ERROR: more info in ' . $this->errorLogFile . "\n";
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

    public function getUsers($count = 20, $start = 0) {
        $req = $this->dbConnection->prepare('SELECT * FROM users ORDER BY id LIMIT ' . $count . ' OFFSET ' . $start);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountUsers() {
        $req = $this->dbConnection->prepare('SELECT COUNT(*) FROM users');
        $req->execute();
        $number = $req->fetch(PDO::FETCH_NUM);
        return intval($number[0]);
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

    public function getProducts($count = 12, $start = 0) {
        $req = $this->dbConnection->prepare('SELECT * FROM products ORDER BY id LIMIT ' . $count . ' OFFSET ' . $start);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountProducts() {
            $req = $this->dbConnection->prepare('SELECT COUNT(*) FROM products');
            $req->execute();
            $number = $req->fetch(PDO::FETCH_NUM);
            return intval($number[0]);
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

    public function getCategories($count = 20, $start = 0) {
        $req = $this->dbConnection->prepare('SELECT * FROM categories ORDER BY id LIMIT ' . $count . ' OFFSET ' . $start);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountCategories() {
            $req = $this->dbConnection->prepare('SELECT COUNT(*) FROM categories');
            $req->execute();
            $number = $req->fetch(PDO::FETCH_NUM);
            return intval($number[0]);
        }

    public function getCategory($id) {
        $req = $this->dbConnection->prepare('SELECT * FROM categories WHERE id = ?');
        $req->execute(array($id));
        if($result = $req->fetch(PDO::FETCH_ASSOC)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getHighestLevelCategories() {
        $req = $this->dbConnection->prepare('SELECT * FROM categories WHERE parent_id IS NULL');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryChildren($id) {
        $req = $this->dbConnection->prepare('SELECT * FROM categories WHERE parent_id = ?');
        $req->execute(array($id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function displayCategoryTree(array $parentCategories, int $level = 0, $setCategoryId = NULL) {
        if(!empty($parentCategories)) {
            foreach ($parentCategories as $parentCategory) {
                echo '<option value="' . $parentCategory['id'] . '"';
                if(!is_null($setCategoryId) && $setCategoryId == $parentCategory['id']) {
                    echo ' selected ';
                }
                echo '> ';
                for ($i = 0; $i < $level; $i++) {
                    echo '-';
                }
                echo ' ' . $parentCategory['name'] . '</option>';
                $children = $this->getCategoryChildren($parentCategory['id']);
                if(!empty($children)) {
                    $nextLevel = $level + 1;
                    $this->displayCategoryTree($children, $nextLevel, $setCategoryId);
                }
            }
        }
    }

    public function getDirectChildrenIds($parentId) {
        $req = $this->dbConnection->prepare('SELECT id FROM categories WHERE parent_id = ?');
        $req->execute(array($parentId));
        return  $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllChildrenIds($parentId) {
        $children = $this->getDirectChildrenIds($parentId);
        if(!empty($children)) {
            foreach ($children as $child) {
                $childrenArray[] = $child['id'];
                if (!empty($this->getDirectChildrenIds($child['id']))) {
                    $childrenArray = array_merge($childrenArray, $this->getAllChildrenIds($child['id']));
                }
            }
        return $childrenArray;
        }
    }
}