<?php require_once 'core/Search.php';
$searchBarDb = new Search();
$searchBarDb->connect();

?>

<div class="container">
    <form action="search-results.php" method="GET" class="block-search">
        <div class="row my-2 align-items-end pb-3">

            <div class="col-12 col-md-3">
                <select name="category"  class="form-select">
                    <option value="">Catégories</option>
                    <?php $highestLevelCategories = $searchBarDb->getHighestLevelCategories();
                    if(empty($_GET['category'])) {
                        $searchBarDb->displayCategoryTree($highestLevelCategories);
                    } else {
                        $searchBarDb->displayCategoryTree($highestLevelCategories, 0, $_GET['category']);
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 col-md-3 mt-3 mt-md-0 d-flex flex-column">
                <div class="input-group mb-1">
                    <span class="input-group-text col-4 col-md-6 col-lg-5">Prix max</span>
                    <input type="number" name="max_price" class="form-control" value="<?= !empty($_GET['max_price']) ? $_GET['max_price'] : '' ?>">
                </div>

                <div class="input-group">
                    <span class="input-group-text col-4 col-md-6 col-lg-5">Prix min</span>
                    <input type="number" name="min_price" class="form-control" value="<?= !empty($_GET['min_price']) ? $_GET['min_price'] : '' ?>">
                </div>
            </div>

            <div class="col-12 col-md-6 mt-3 mt-md-0 d-flex flex-column">
                <div class="mb-1">
                    <input type="search" name="criteria" class="form-control" placeholder="Entrez votre recherche" value="<?= !empty($_GET['criteria']) ? $_GET['criteria'] : '' ?>">
                </div>

                    <div class="col-2">
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </div>
            </div>


        </div>
    </form>
</div>