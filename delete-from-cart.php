<?php
    require_once 'core/Cart.php';
    $userCart = new Cart();
    $userCart->connect();
    if (isset($_GET['id'])) {
    $deletedProduct = $userCart->deleteFromCart($_GET['id']);
    }

    if(!isset($_GET['id']) || $deletedProduct === false) {
        header('location: index.php?carterror=wrongdelete');
    } else {
        header('location: user-cart.php');
    }
?>