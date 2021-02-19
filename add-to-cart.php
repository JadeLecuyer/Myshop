<?php
    require_once 'core/Cart.php';
    $userCart = new Cart();
    $userCart->connect();
    if (isset($_GET['id'])) {
    $addedProduct = $userCart->addToCart($_GET['id']);
    }

    if(!isset($_GET['id']) || $addedProduct === false) {
        header('location: index.php?carterror=wrongid');
    } else {
        header('location: index.php');
    }
?>