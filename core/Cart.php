<?php
require_once 'DBconfig.php';
require_once 'core/Database.php';

class Cart extends Database {

    public function __construct() {
        parent::__construct();

        if(!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart($product_id) {
        if(!$this->getProduct($product_id)) {
            return 'wrongid';
        } elseif(isset($_SESSION['cart'][$product_id])) {
            return 'alreadyadded';
        } else {     
            $_SESSION['cart'][$product_id] = [];
            return 'success';
        }
    }

    public function deleteFromCart($product_id) {
        if(isset($_SESSION['cart'][$product_id]) && $this->getProduct($product_id)) {
            unset($_SESSION['cart'][$product_id]);
            return true;
        } else {
            return false;
        }
    }

}