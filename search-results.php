<?php
    $title = "Recherche - My Shop";
    $description = "Boutique en ligne My Shop - Résultats de la recherche";
    $currentPage = 'search-results';
    require_once 'core/Search.php';
    $searchDb = new Search();
    $searchDb->connect();
    if(isset($_GET['page']) && $_GET['page'] < 1) {
        $_GET['page'] = 1;
    }

    if(empty($_GET)) {
        $emptyInput[] = 'Renseignez au moins un critère de recherche.';
    } else {
        $results = $searchDb->searchMatches($_GET['criteria'], $_GET['category'], $_GET['max_price'], $_GET['min price']);
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
                <?php if($results['status'] === 'fail') {
                    echo '<div class="alert alert-danger">' . implode("<br>", $results['message']) . '</div>';
                } elseif($results['status'] === 'success') { ?>
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4">
                    <div class="col ms-auto">
                        <select name="sorting" class="form-select block-search__pertinence">
                            <option value="">Options de tri</option>
                            <option value="price-asc">Prix croissant</option>
                            <option value="price-desc">Prix décroissant</option>
                            <option value="alphabet-asc">A -> Z</option>
                            <option value="alphabet-desc">Z -> A</option>
                        </select>
                    </div>  
                </div>

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

                        $displayedResults = array_slice($results['results'], $offset, $numberOfProducts);
    
                        foreach($displayedResults as $product) {
                            include 'includes/product-card-inc.php';
                        } ?>

            <?php } ?>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>