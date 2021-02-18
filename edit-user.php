<?php
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['admin'] !== '1') {
        header('location: index.php');
    }

    $title = "Administrateur - My Shop";
    $description = "Administration de la boutique en ligne My Shop - Modifier un utilisateur";
    $currentPage = 'edit-user';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();

    if(isset($_GET['id'])) {
        $user = $dbAdmin->getUser($_GET['id']);
    }

    if(isset($_POST['id']) && isset($_POST['email']) && isset($_POST['admin'])) {
        $editedUser = $dbAdmin->editUser($_POST['id'], $_POST['email'], $_POST['admin']);
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
            <a href="admin.php?table=users" class="btn btn-secondary my-3">Revenir à la table utilisateurs</a>
            <?php if (isset($editedUser) && ($editedUser == 'success')) {
                echo '<div class="alert alert-success">Cet utilisateur a été modifié avec succès.</div>';
            } else {
                if ((!isset($user) && !isset($editedUser)) || $user === false) {
                echo '<div class="alert alert-danger">Cet utilisateur n\'existe pas. Veuillez spécifier un identifiant valide.</div>';
                } else {
                    if (isset($editedUser) && $editedUser != 'success') {
                        echo '<div class="alert alert-danger">' . implode("<br>", $editedUser) . '</div>';
                        $user = $dbAdmin->getUser($_POST['id']);
                    } ?>


            <form action="edit-user.php" method="POST">

                <?php if($user) { echo '<input type="hidden" name="id" value="' . $user['id'] . '">';} ?>

                <div class="my-3">
                    <p>Nom de l'utilisateur : <?= $user['username'] ?> </p>
                </div>

                <div class="my-3">
                    <label for="description" class="form-label">E-mail de l'utilisateur</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $user ? $user['email'] : '' ?>" required></input>
                </div>

                <div class="my-4">
                    <p>Cet utilisateur est-il administrateur ?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin" id="is_admin" value="1" <?= $user['admin'] == 1 ? 'checked' : ''?> required>
                        <label class="form-check-label" for="is_admin">Oui, cet utilisateur est administrateur</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin" id="not_admin" value="0" <?= ($user['admin'] == 0 || is_null($user['admin'])) ? 'checked' : ''?>>
                        <label class="form-check-label" for="not_admin">Non, cet utilisateur n'est pas administrateur</label>
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