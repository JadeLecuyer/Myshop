<?php
    session_start();

    $title = "Accueil - My Shop";
    $description = "Boutique en ligne My Shop";
    $currentPage = 'index';
    require_once 'core/Database.php';
    $db = new Database();
    $db->connect();
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
            <?php include 'includes/searchbar-inc.php' ?>
            <div class="container">
                <?php if(isset($_GET['carterror'])) {
                    if ($_GET['carterror'] === 'wrongid') {
                        echo '<div class="alert alert-danger">Le produit n\'existe pas : il n\'a pas pu être ajouté à votre panier.</div>';
                    } elseif($_GET['carterror'] === 'wrongdelete') {
                        echo '<div class="alert alert-danger">Impossible de supprimer de votre panier un produit inexistant ou n\'y étant pas.</div>';
                    } 
                }
                ?>
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4">
                    <?php $productsPerPage = 12;
                        $numberOfProducts = $db->getCountProducts();
                        $numberOfPages = $numberOfProducts / $productsPerPage;
                        if(!is_int($numberOfPages)) {
                            $numberOfPages = floor($numberOfPages) + 1;
                        }
                        if(isset($_GET['page'])) {
                            $offset = ($_GET['page'] - 1) * $productsPerPage;
                        } else {
                            $offset = 0;
                        }
    
                        $products = $db->getProducts($productsPerPage, $offset);
                        foreach($products as $product) {
                            include 'includes/product-card-inc.php';
                        } ?>
                </div>
                <nav aria-label="Navigation des pages produits">
                    <ul class="pagination flex-wrap">
                        <?php for($i = 1; $i <= $numberOfPages; $i++) {
                            echo '<li class="page-item';
                            if ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) {
                                echo ' active';
                            }
                            echo '"><a class="page-link" href="index.php?page=' . $i. '">' . $i . '</a></li>';
                        }?>
                    </ul>
                </nav>
            </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>
