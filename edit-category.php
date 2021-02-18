<?php
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['admin'] !== '1') {
        header('location: index.php');
    }

    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop - Modifier our ajouter une catégorie";
    $currentPage = 'edit-category';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();
    $isEdit = !empty($_POST['id']);

    if(isset($_GET['id'])) {
        $category = $dbAdmin->getCategory($_GET['id']);
    }

    $emptyInput = [];
    if (!empty($_POST)) {
        if(empty($_POST['name'])) {
            $emptyInput[] = 'Renseignez un nom.';
        }
        if(empty($_POST['parent_id'])) {
            $emptyInput[] = 'Renseignez une catégorie parente.';
        }
        if (count($emptyInput) === 0) {
            if($isEdit === true) {
                $editedCategory = $dbAdmin->editCategory($_POST['id'], $_POST['name'], $_POST['parent_id']);
            } else {
                $addedCategory = $dbAdmin->addCategory($_POST['name'], $_POST['parent_id']);
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
        <a href="admin.php?table=categories" class="btn btn-secondary my-3">Revenir à la table catégories</a>
            <?php if (isset($editedCategory) && ($editedCategory === 'success')) {
                echo '<div class="alert alert-success">Cette catégorie a été modifiée avec succès.</div>';
            } elseif (isset($addedCategory) && ($addedCategory === 'success')) {
                echo '<div class="alert alert-success">Cette catégorie a été créée avec succès.</div>';
            } else {
                if ($editedCategory === 'wrongid' || $category === false) {
                echo '<div class="alert alert-danger">Cete catégorie n\'existe pas. Veuillez spécifier un identifiant valide.</div>';
                } else {
                    if (isset($editedCategory) && $editedProduct !== 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $editedCategory) . '</div>';
                        $category = $dbAdmin->getCategory($_POST['id']);
                    } elseif (isset($addedCategory) && $addedCategory !== 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $addedCategory) . '</div>';
                    } elseif (count($emptyInput) !== 0) {
                        echo '<div class="alert alert-danger">' . implode("<br>", $emptyInput) . '</div>';
                    } ?>

                    <form action="edit-category.php" method="POST">

                    <?php if(isset($category)){ echo '<input type="hidden" name="id" value="' . $category['id'] . '">';} ?>

                        <div class="my-3">
                            <label for="name" class="form-label">Nom de la catégorie</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= $category ? $category['name'] : '' ?>" required>
                        </div>

                        <div class="my-3">
                            <label for="parent_id" class="form-label">Catégorie parente directe</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="NULL">Pas de catégorie parente</option>
                                <?php
                                $highestLevelCategories = $dbAdmin->getHighestLevelCategories();
                                $dbAdmin->displayCategoryTree($highestLevelCategories, 0, $category['parent_id']);
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary my-3">Confirmer</button>

                    </form>

                <?php }} ?>
        </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>