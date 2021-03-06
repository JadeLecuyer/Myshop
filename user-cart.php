<?php
    session_start();

    $title = "Panier - My Shop";
    $description = "Panier de la boutique en ligne My Shop";
    $currentPage = 'cart';
    require_once 'core/Cart.php';
    $userCart = new Cart();
    $userCart->connect();
    if(isset($_GET['page']) && $_GET['page'] < 1) {
        $_GET['page'] = 1;
    }
?>

<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <?php require 'includes/head-inc.php'; ?>        
    </head>
    <body>    
        <?php require 'includes/layouts/header-inc.php'; ?>
        <main>
        <div class="container">
            <?php if(count($_SESSION['cart']) === 0) { ?>
                <div class="w-100 text-center text-reset">
                        Votre panier est actuellement vide !
                        <div class="my-2"><a href="index.php" class="btn btn-secondary">Continuer mes achats</a></div>
                </div>
            <?php } else { ?>
            <div class="d-flex flex-column flex-md-row">

                <div class="block-cart__cart">
                    <!-- <h4 class="text-uppercase">Bonjour <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'invité' ?>, voici votre panier</h4> -->
                    <h4 class="text-uppercase">Mon panier</h4>
                        <?php 
                        $productsIds = array_keys($_SESSION['cart']);
                        $totalPrice = 0;
                        foreach($productsIds as $productId) {
                            $product = $userCart->getProduct($productId);
                            $totalPrice += floatval($product['price']); ?>
                            <div class="py-3 me-5 d-flex card-cart">
                                <div class="me-3">
                                    <a href="viewproduct.php?id=<?= $product['id'] ?>">
                                        <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="card-cart__product-img">
                                    </a>
                                </div>
                                <div class="d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="card-cart__price fw-bold fs-5"><?= $product['price'] ?>€</div>
                                        <div><a href="viewproduct.php?id=<?= $product['id'] ?>" class="link-dark text-decoration-none"><?= $product['name'] ?></a></div>
                                    </div>
                                    <a href="delete-from-cart.php?id=<?=$product['id']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash card-cart__delete-logo" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                </div>

                <div class="block-cart__total mt-4 mt-md-0">
                    <div class="w-100 block-cart__total-wrapper">
                        <h4 class="text-uppercase">Total</h4>
                        <div class="d-flex justify-content-between"> <span class="fw-bold">Sous-total</span> <span><?= $totalPrice ?>€</span></div>
                        <div class="d-flex justify-content-between"><span class="fw-bold">Livraison</span> <span>Gratuit</span></div>
                        <a href="#" class="btn btn-custom w-100 my-3">Paiement</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>