<?php
    $title = "Administration - My Shop";
    $description = "Administration de la boutique en ligne My Shop";
    $currentPage = 'admin';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator('localhost', 'root', 'root', 3306, 'my_shop');
    $dbAdmin->connect();
?>

<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <?php require 'includes/head.inc.php'; ?>        
    </head>
    <body>    
        <?php require 'includes/layouts/header.inc.php'; ?>
        <div class="container">
            <h2 class="my-4">Bonjour Administrateur</h2>
        </div>
        <?php if($_GET['table'] == 'users') { ?>

        <div class="container">
            <a href="admin.php" class="btn btn-secondary mb-2">Retour au choix de la table</a>
            <h3 class="my-2">Utilisateurs</h3>
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
                <?php $users = $dbAdmin->getUsers();
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
                            <button class="btn btn-success">Modifier</button>
                            <button class="btn btn-danger">Supprimer</button>
                        </td>';
                        echo '</tr>' ;
                    }
                ?>
                </tbody>
            </table>
        </div>

        <?php } elseif($_GET['table'] == 'products') { ?>

        <div class="container">
            <a href="admin.php" class="btn btn-secondary mb-2">Retour au choix de la table</a>
            <h3 class="my-2">Produits</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $products = $dbAdmin->getProducts();
                    foreach($products as $product) {
                        echo '<tr>';
                        echo '<td>' . $product['id'] . '</td>';
                        echo '<td>' . $product['name'] . '</td>' ;
                        echo '<td>' . $product['price'] . '</td>' ;
                        echo '<td>' . $product['category_id'] . '</td>' ;
                        echo '<td>
                            <button class="btn btn-success">Modifier</button>
                            <button class="btn btn-danger">Supprimer</button>
                            </td>';
                        echo '</tr>' ;
                    }
                ?>
                </tbody>
            </table>
        </div>


        <?php } else { ?>
        <div class="container">
            <form action="admin.php" method="GET">
                <label for="table" class="form-label">Quelle table voulez-vous consulter ?</label>
                <select name="table" id="table" class="form-select w-auto">
                    <option value="users">Users</option>
                    <option value="products">Products</option>
                </select>
                <button type="submit" class="btn btn-primary my-3">Aller à la table</button>
            </form>
        </div>
        <?php } ?>

        <?php require 'includes/layouts/footer.inc.php'; ?>
    </body>
</html>