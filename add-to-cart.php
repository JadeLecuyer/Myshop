<?php
    require_once 'core/Cart.php';
    $userCart = new Cart();
    $userCart->connect();
    if (isset($_GET['id'])) {
    $addedProduct = $userCart->addToCart($_GET['id']);
    }

    if(!isset($_GET['id']) || $addedProduct === 'wrongid') {
        header('location: index.php?carterror=wrongid');
    } elseif($addedProduct === 'alreadyadded') {
        header('location: index.php?carterror=alreadyadded');
    } elseif($addedProduct === 'success') {
        header('location: index.php');
    }
?>