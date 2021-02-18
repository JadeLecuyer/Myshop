<?php

session_start();

$title = "Connexion - My Shop";
$description = "Connexion - Boutique en ligne My Shop";
$currentPage = 'signin';

$errorMessage = array();
require_once 'DBconfig.php';

if(isset($_POST['submit'])) {

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

mysqli_select_db($con, DB_NAME);

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

$username = strip_tags(mysqli_real_escape_string($con,trim($username)));
$password = strip_tags(mysqli_real_escape_string($con,trim($password)));


$s = "SELECT * FROM users WHERE username = '$username'";

$result = mysqli_query($con, $s);

$num = mysqli_num_rows($result);

if($num>0)
{
    $row = mysqli_fetch_array($result);
    $hashed_password = $row['password'];
    if(password_verify($password, $hashed_password))
    {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['id'];
        $_SESSION['admin'] = $row['admin'];
        header ('location: index.php');
    }
    else
    {
        $errorMessage[] = "Mot de passe incorrect.\n";
    }
}
else
{
    $errorMessage[] = "Nom d'utilisateur inconnu.\n";
}

}
?>


<!DOCTYPE html>
<html>
    <head>
        <?php require 'includes/head-inc.php'; ?>
    </head>

    <body>
    <?php require 'includes/layouts/header-inc.php'; ?>
    <div id="main">
        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-white">Se connecter</h3>
                                <div class="form-group">
                                    <label for="username" class="text-white">Nom d'utilisateur :</label><br>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-white">Mot de passe :</label><br>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="submit">
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="S'identifier">
                                </div>
                                <div id="register-link" class="text-right">
                                    <a href="signup.php" class="text-white">Créer un compte</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <?php if ($errorMessage): ?> <div class="alert alert-danger"><?php echo implode("<br>", $errorMessage) ?></div>
            <?php endif ?>
        </div>
    </div>
    <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>
