<?php
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['admin'] !== '1') {
        header('location: index.php');
    }

    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop - Modifier ou ajouter un produit";
    $currentPage = 'edit-product';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();
    $isEdit = !empty($_POST['id']);

    if(isset($_GET['id'])) {
        $product = $dbAdmin->getProduct($_GET['id']);
    }

    $emptyInput = [];
    if (!empty($_POST)) {
        if(empty($_POST['name'])) {
            $emptyInput[] = 'Renseignez un nom.';
        }
        if(empty($_POST['description'])) {
            $emptyInput[] = 'Renseignez une description.';
        }
        if(empty($_POST['price'])) {
            $emptyInput[] = 'Renseignez un prix.';
        }
        if(empty($_FILES['img']['name']) && !$isEdit) {
            $emptyInput[] = 'Choisissez une photo.';
        }
        if(empty($_POST['category_id'])) {
            $emptyInput[] = 'Choisissez une catégorie.';
        }

        if (count($emptyInput) === 0) {
            if($isEdit === true) {
                $editedProduct = $dbAdmin->editProduct($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_FILES['img'], $_POST['category_id']);
            } else {
                $addedProduct = $dbAdmin->addProduct($_POST['name'], $_POST['description'], $_POST['price'], $_FILES['img'], $_POST['category_id']);
            }
        }
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
            <a href="admin.php?table=products" class="btn btn-secondary my-3">Revenir à la table produits</a>
            <?php if (isset($editedProduct) && ($editedProduct['status'] === 'success')) {
                echo '<div class="alert alert-success">Ce produit a été modifié avec succès.</div>';
                if(isset($editedProduct['message'])) {
                    echo '<div class="alert alert-primary">' . $editedProduct['message'] . '</div>';
                }
            } elseif (isset($addedProduct) && ($addedProduct === 'success')) {
                echo '<div class="alert alert-success">Ce produit a été créé avec succès.</div>';
            } else {
                if ($editedProduct === 'wrongid' || $product === false) {
                echo '<div class="alert alert-danger">Ce produit n\'existe pas. Veuillez spécifier un identifiant valide.</div>';
                } else {
                    if (isset($editedProduct) && $editedProduct['status'] !== 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $editedProduct['errorMessage']) . '</div>';
                        $product = $dbAdmin->getProduct($_POST['id']);
                    } elseif (isset($addedProduct) && $addedProduct !== 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $addedProduct) . '</div>';
                    } elseif (count($emptyInput) !== 0) {
                        echo '<div class="alert alert-danger">' . implode("<br>", $emptyInput) . '</div>';
                    } ?>

            <form action="edit-product.php" method="POST" enctype="multipart/form-data">

                <?php if(isset($product['id'])){ echo '<input type="hidden" name="id" value="' . $product['id'] . '">';} ?>

                <div class="my-3">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $product ? $product['name'] : '' ?>" required>
                </div>

                <div class="my-3">
                    <label for="description" class="form-label">Description du produit</label>
                    <textarea name="description" id="description" class="form-control" required><?= $product ? $product['description'] : '' ?></textarea>
                </div>

                <div class="my-3">
                    <label for="description" class="form-label">Prix du produit</label>
                    <input type="number" name="price" id="price" class="form-control w-auto" value="<?= $product ? $product['price'] : '' ?>" required>
                </div>

                <div class="my-3">
                    <?php if($product && !is_null($product['img'])) { echo '<img src="' . $product['img'] . '" alt="Photo du produit" class="d-block img-fluid">';} ?>
                    <label for="img" class="form-label">Photo du produit</label>
                    <input type="file" name="img" id="img" accept="image/png, image/gif, image/jpeg" class="form-control">
                    <div class="form-text">L'image doit être de type JPEG, PNG ou GIF et faire moins de 300ko.</div>
                </div>

                <div class="my-3">
                    <div>
                        <label for="category_id" class="form-label">Catégorie parente de plus bas niveau</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <?php
                            $highestLevelCategories = $dbAdmin->getHighestLevelCategories();
                            $dbAdmin->displayCategoryTree($highestLevelCategories, 0, $product['category_id']);
                            ?>
                        </select>
                    </div>
                    <div>
                        <div class="form-text">Si vous ne trouvez pas de catégorie correspondant à votre besoin rendez-vous sur la <a href="admin.php?table=categories">table catégorie</a> pour la créer.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary my-3">Confirmer</button>
            </form>

            <?php }} ?>
        </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>