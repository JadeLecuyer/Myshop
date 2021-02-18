<?php
    session_start();

    require_once 'core/Database.php';
    $db = new Database();
    $db->connect();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = $db->getproduct($id);
    }

    $title = (isset($product) && $product !== false) ? $product['name'] . ' - My Shop' : 'Produit inexistant - My Shop';
    $description = (isset($product) && $product !== false) ? 'Boutique ne ligne My Shop - visualisation du produit ' . $product['name'] : 'Boutique en ligne My Shop - erreur : produit inexistant';
    $currentPage = 'viewproduct';
    
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
                <div>
                    <a href="index.php" class="btn btn-secondary">Retour à la boutique</a>
                </div>
                <?php if (!isset($_GET['id']) || $product === false) { ?>
                    <div class="alert alert-danger my-4">Ce produit n'existe pas ! Veuillez sélectionner un produit existant.</div>
                <?php } else { ?>
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col g-5">
                            <img src="<?= $product['img'] ?>" alt="<?= $product['name']?>" class="block-product__img">
                        </div>
                        <div class="col g-5">
                            <h2 class="fw-bold"><?= $product['name']?></h2>
                            <p class="my-4"><?= $product['description']?></p>
                                <p class="fs-4"><?= $product['price']?>€</p>
                                <a href="#" class="btn btn-custom fw-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3 btn-custom__logo" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    Add to cart
                                </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>