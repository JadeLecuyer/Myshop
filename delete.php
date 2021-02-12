<?php
    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop";
    $currentPage = 'delete';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    if(isset($_POST['id']) && $_POST['table'] == 'users') {
        $message = $dbAdmin->deleteUser($_POST['id']);
    } elseif (isset($_POST['id']) && $_POST['table'] == 'products') {
        $message = $dbAdmin->deleteProduct($_POST['id']);
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
                <?php if ($_GET['table'] == 'users') { ?>
                <form action="delete.php" method="POST">
                    <label class="form-label">Etes-vous certain de vouloir supprimer cet utilisateur ?</label>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="table" value="users">
                    <div class="my-2">
                        <button type="submit" class="btn btn-danger">Oui</button>
                        <a href="admin.php?table=users" class="btn btn-secondary">Non, revenir à la table</a>
                    </div>
                </form>

                <?php } elseif ($_GET['table'] == 'products') { ?>
                <form action="delete.php" method="POST">
                    <label class="form-label">Etes-vous certain de vouloir supprimer ce produit ?</label>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="table" value="products">
                    <div class="my-2">
                        <button type="submit" class="btn btn-danger">Oui</button>
                        <a href="admin.php?table=products" class="btn btn-secondary">Non, revenir à la table</a>
                    </div>
                </form>

                <?php } elseif (isset($_POST['id']) && ($_POST['table'] == 'users' || $_POST['table'] == 'products')) { ?>
                    <p><?= $message; ?></p>
                    <a href="admin.php?table=<?= $_POST['table'] ?>" class="btn btn-secondary">Retour à la table</a>

                <?php } else { ?>
                    <p>Paramètres incorrects !</p>
                    <a href="admin.php" class="btn btn-secondary">Retour au choix de la table</a>
                <?php } ?>
            </div>
        </main>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>