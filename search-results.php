<?php
    session_start();

    $title = "Recherche - My Shop";
    $description = "Boutique en ligne My Shop - Résultats de la recherche";
    $currentPage = 'search-results';
    require_once 'core/Search.php';
    $searchDb = new Search();
    $searchDb->connect();
    if(isset($_GET['page']) && $_GET['page'] < 1) {
        $_GET['page'] = 1;
    }

    if(!empty($_GET)) {
        $results = $searchDb->searchMatches($_GET['criteria'], $_GET['category'], $_GET['max_price'], 
        $_GET['min price'], $_GET['sorting']);
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
        <?php include 'includes/searchbar-inc.php'; ?>

            <div class="container">
                <?php if(empty($_GET)) {
                    echo '<div class="container">
                    <div class="alert alert-danger">Veuillez choisir au moins un critère.</div>
                    <a href="index.php" class="btn btn-secondary">Retour à l\'index</a>
                    </div>';
                } ?>
                <?php if($results['status'] === 'fail') {
                    echo '<div class="alert alert-danger">' . implode("<br>", $results['message']) . '</div>';
                } elseif($results['status'] === 'success') { ?>

                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4">
                    <?php $productsPerPage = 12;
                        $numberOfProducts = count($results['results']);
                        $numberOfPages = $numberOfProducts / $productsPerPage;
                        if(!is_int($numberOfPages)) {
                            $numberOfPages = floor($numberOfPages) + 1;
                        }
                        if(isset($_GET['page'])) {
                            $offset = ($_GET['page'] - 1) * $productsPerPage;
                        } else {
                            $offset = 0;
                        }

                        $displayedResults = array_slice($results['results'], $offset, $productsPerPage);
    
                        foreach($displayedResults as $product) {
                            include 'includes/product-card-inc.php';
                        } ?>
                </div>

                <nav aria-label="Navigation des pages résultats de la recherche">
                    <ul class="pagination flex-wrap">
                        <?php for($i = 1; $i <= $numberOfPages; $i++) {
                            echo '<li class="page-item';
                            if ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) {
                                echo ' active';
                            }
                            echo '"><a class="page-link" href="search-results.php?criteria=' . $_GET['criteria'] 
                            . '&category=' . $_GET['category'] . '&max_price=' . $_GET['max_price'] 
                            . '&min_price=' . $_GET['min_price'] . '&sorting=' . $_GET['sorting'] . '&page=' . $i. '">' . $i . '</a></li>';
                        }?>
                    </ul>
                </nav>

            <?php } ?>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>