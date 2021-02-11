<?php
    $title = "Accueil - My Shop";
    $description = "Boutique en ligne My Shop";
    $currentPage = 'index';
    require_once 'core/admin/DBAdministrator.php';
    $dbAdmin = new DBAdministrator();
    $dbAdmin->connect();

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }
?>

<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <?php require 'includes/head.inc.php'; ?>        
    </head>
    <body>    
        <?php require 'includes/layouts/header.inc.php'; ?>
        <?php require 'includes/layouts/footer.inc.php'; ?>
    </body>
</html>