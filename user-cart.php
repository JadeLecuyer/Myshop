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
            <h4>Bonjour <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'invité' ?>, voici votre panier</h4>
            <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $productsIds = array_keys($_SESSION['cart']);
                        $totalPrice = 0;
                        foreach($productsIds as $productId) {
                            $product = $userCart->getProduct($productId);
                            $totalPrice += floatval($product['price']);
                            echo '<tr>';
                            echo '<td><img src="' . $product['img'] . '" class="block-cart__product-img"></td>';
                            echo '<td>' . $product['name'] . '</td>' ;
                            echo '<td>' . $product['price'] . '€</td>' ;
                            echo '<td>
                                <a href="delete-from-cart.php?id=' . $product['id'] . '" class="btn btn-danger">Supprimer</a>
                                </td>';
                            echo '</tr>' ;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Prix total</th>
                                <td colspan="2"><?= $totalPrice ?>€</td>
                            </tr>
                        </tfoot>
                </table>
            </div>
        </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>