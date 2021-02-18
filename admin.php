<?php
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['admin'] !== '1') {
        header('location: index.php');
    }

    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop";
    $currentPage = 'admin';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();
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
            <h2 class="my-4">Bonjour <?= $_SESSION['username'] ?></h2>
        </div>
        <?php if($_GET['table'] == 'users') { ?>

        <div class="container">
            <a href="admin.php" class="btn btn-secondary mb-2">Retour au choix de la table</a>
            <h3 class="my-2">Utilisateurs</h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">e-mail</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $usersPerPage = 20;
                        $numberOfUsers = $dbAdmin->getCountUsers();
                        $numberOfPages = $numberOfUsers / $usersPerPage;
                        if(!is_int($numberOfPages)) {
                            $numberOfPages = floor($numberOfPages) + 1;
                        }
                        if(isset($_GET['page'])) {
                            $offset = ($_GET['page'] - 1) * $usersPerPage;
                        } else {
                            $offset = 0;
                        }
                        
                        $users = $dbAdmin->getUsers($usersPerPage, $offset);
                        foreach($users as $user) {
                            echo '<tr>';
                            echo '<td>' . $user['id'] . '</td>';
                            echo '<td>' . $user['username'] . '</td>' ;
                            echo '<td>' . $user['email'] . '</td>' ;
                            if ($user['admin'] == 1) {
                                echo '<td> ADM </td>';
                            } else {
                                echo '<td></td>';
                            }
                            echo '<td>
                                <a href="edit-user.php?id=' . $user['id'] . '" class="btn btn-success">Modifier</a>
                                <a href="delete.php?id=' . $user['id'] . '&table=users" class="btn btn-danger">Supprimer</a>
                            </td>';
                            echo '</tr>' ;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Navigation table users">
                <ul class="pagination flex-wrap">
                    <?php for($i = 1; $i <= $numberOfPages; $i++) {
                        echo '<li class="page-item';
                        if ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) {
                            echo ' active';
                        }
                        echo'"><a class="page-link" href="admin.php?table=users&page=' . $i. '">' . $i . '</a></li>';
                    }?>
                </ul>
            </nav>
        </div>

        <?php } elseif($_GET['table'] == 'products') { ?>

        <div class="container">
            <a href="admin.php" class="btn btn-secondary mb-2">Retour au choix de la table</a>
            <div class="d-flex justify-content-between align-items-end">
                <h3 class="my-2">Produits</h3>
                <a href="edit-product.php" class="btn btn-primary mb-2">Ajouter un produit</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Catégorie parente de plus bas niveau</th>
                            <th scope="col" class="col-md-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $productsPerPage = 20;
                        $numberOfProducts = $dbAdmin->getCountProducts();
                        $numberOfPages = $numberOfProducts / $productsPerPage;
                        if(!is_int($numberOfPages)) {
                            $numberOfPages = floor($numberOfPages) + 1;
                        }
                        if(isset($_GET['page'])) {
                            $offset = ($_GET['page'] - 1) * $productsPerPage;
                        } else {
                            $offset = 0;
                        }

                        $products = $dbAdmin->getProducts($productsPerPage, $offset);
                        foreach($products as $product) {
                            echo '<tr>';
                            echo '<td>' . $product['id'] . '</td>';
                            echo '<td>' . $product['name'] . '</td>' ;
                            echo '<td>' . $product['price'] . '</td>' ;
                            echo '<td>' . $dbAdmin->getCategory($product['category_id'])['name'] . '</td>' ;
                            echo '<td>
                                <a href="edit-product.php?id=' . $product['id'] . '" class="btn btn-success my-1">Modifier</a>
                                <a href="delete.php?id=' . $product['id'] . '&table=products" class="btn btn-danger">Supprimer</a>
                                </td>';
                            echo '</tr>' ;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Navigation table products">
                <ul class="pagination flex-wrap">
                    <?php for($i = 1; $i <= $numberOfPages; $i++) {
                        echo '<li class="page-item';
                        if ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) {
                            echo ' active';
                        }
                        echo '"><a class="page-link" href="admin.php?table=products&page=' . $i. '">' . $i . '</a></li>';
                    }?>
                </ul>
            </nav>
        </div>

        <?php } elseif($_GET['table'] == 'categories') { ?>

        <div class="container">
            <a href="admin.php" class="btn btn-secondary mb-2">Retour au choix de la table</a>
            <div class="d-flex justify-content-between align-items-end">
                <h3 class="my-2">Catégories</h3>
                <a href="edit-category.php" class="btn btn-primary mb-2">Ajouter une catégorie</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">ID de la catégorie parente directe</th>
                            <th scope="col">Nom de la catégorie parente directe</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $categoriesPerPage = 20;
                        $numberOfCategories = $dbAdmin->getCountCategories();
                        $numberOfPages = $numberOfCategories / $categoriesPerPage;
                        if(!is_int($numberOfPages)) {
                            $numberOfPages = floor($numberOfPages) + 1;
                        }
                        if(isset($_GET['page'])) {
                            $offset = ($_GET['page'] - 1) * $categoriesPerPage;
                        } else {
                            $offset = 0;
                        }

                        $categories = $dbAdmin->getCategories($categoriesPerPage, $offset);
                        foreach($categories as $category) {
                            echo '<tr>';
                            echo '<td>' . $category['id'] . '</td>';
                            echo '<td>' . $category['name'] . '</td>' ;
                            echo '<td>' . $category['parent_id'] . '</td>' ;
                            echo '<td>' . $dbAdmin->getCategory($category['parent_id'])['name'] . '</td>' ;
                            echo '<td>
                                <a href="edit-category.php?id=' . $category['id'] . '" class="btn btn-success">Modifier</a></td>';
                            echo '</tr>' ;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Navigation table categories">
                <ul class="pagination flex-wrap">
                    <?php for($i = 1; $i <= $numberOfPages; $i++) {
                        echo '<li class="page-item';
                        if ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) {
                            echo ' active';
                        }
                        echo '"><a class="page-link" href="admin.php?table=categories&page=' . $i. '">' . $i . '</a></li>';
                    }?>
                </ul>
            </nav>
        </div>


        <?php } else { ?>
        <div class="container">
            <form action="admin.php" method="GET">
                <label for="table" class="form-label">Quelle table voulez-vous consulter ?</label>
                <select name="table" id="table" class="form-select w-auto">
                    <option value="users">Users</option>
                    <option value="products">Products</option>
                    <option value="categories">Categories</option>
                </select>
                <button type="submit" class="btn btn-primary my-3">Aller à la table</button>
            </form>
        </div>
        <?php } ?>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>