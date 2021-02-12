<?php
    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop";
    $currentPage = 'edit-product';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();

    if(isset($_GET['id'])) {
        $product = $dbAdmin->getProduct($_GET['id']);
    }

    var_dump($_FILES, $_POST);

    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description'])
    && isset($_POST['price']) && isset($_FILES['img'])) {
        $editedProduct = $dbAdmin->editProduct($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['img']);
    } elseif(!isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description'])
    && isset($_POST['price']) && isset($_POST['img'])) {
        $addedProduct = $dbAdmin->addProduct($_POST['name'], $_POST['description'], $_POST['price'], $_FILES['img']);
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
            <?php if (isset($editedProduct) && ($editedProduct == 'success')) {
                echo '<div class="alert alert-success">Ce produit a été modifié avec succès.</div>';
            } elseif (isset($addedProduct) && ($addedProduct == 'success')) {
                echo '<div class="alert alert-success">Ce produit a été créé avec succès.</div>';
            } else {
                if ($editedProduct === 'wrongid' || $product === false) {
                echo '<div class="alert alert-danger">Ce produit n\'existe pas. Veuillez spécifier un identifiant valide.</div>';
                } else {
                    if (isset($editedProduct) && $editedProduct != 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $editedProduct) . '</div>';
                        $product = $dbAdmin->getProduct($_POST['id']);
                    } elseif (isset($addedProduct) && $addedProduct != 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $addedProduct) . '</div>';
                        $product = $_POST;
                    } ?>

            <form action="edit-product.php" method="POST" enctype="multipart/form-data">

                <?php if(isset($product['id'])){ echo '<input type="hidden" name="id" value="' . $product['id'] . '">';} ?>

                <div class="my-3">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $product ? $product['name'] : '' ?>">
                </div>

                <div class="my-3">
                    <label for="description" class="form-label">Description du produit</label>
                    <textarea name="description" id="description" class="form-control" value="<?= $product ? $product['description'] : '' ?>"></textarea>
                </div>

                <div class="my-3">
                    <label for="description" class="form-label">Prix du produit</label>
                    <input type="number" name="price" id="price" class="form-control w-auto" value="<?= $product ? $product['price'] : '' ?>">
                </div>

                <div class="my-3">
                    <?php if($product && !is_null($product['img'])) { echo '<img src="' . $product['img'] . '" alt="Photo du produit" class="d-block img-fluid">';} ?>
                    <label for="img" class="form-label">Photo du produit</label>
                    <input type="file" name="img" id="img" accept="image/png, image/gif, image/jpeg" class="form-control">
                    <div class="form-text">L'image doit être de type JPEG, PNG ou GIF et faire moins de .</div>
                </div>

                <button type="submit" class="btn btn-primary my-3">Confirmer</button>
            </form>

            <?php }} ?>
        </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>