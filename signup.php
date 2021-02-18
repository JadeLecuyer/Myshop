<?php

$title = "Inscription - My Shop";
$description = "Inscription - Boutique en ligne My Shop";
$currentPage = 'signup';

$errorMessage = array();
$success = null;

if(isset($_POST['valide'])) {
    // Test form validation
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];
//add

        if (empty($lastname) || empty($firstname) || empty($username) || empty($email) || empty($password) || empty($password_confirmation))
        {
            $errorMessage[] = "Tout les champs ne sont pas remplis.\n";
        }
//add
        if (strlen($username)<3 || strlen($username)>10)
        {
            $errorMessage[] = "Nom d'utilisateur invalide. \r\n\n";
        }
        if (strlen($password)<3 || strlen($password)>10)
        {
            $errorMessage[] = "Mot de passe invalide.\n";
        }
        if ($password != $password_confirmation)
        {
            $errorMessage[] = "Les mots de passes sont différents.\n";
        }
        $email_regex = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/'; 
        if (!preg_match($email_regex, $email)) 
        {
            $errorMessage[] = "L'email n'est pas valide.\n";
        }
//add

        $queryus = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($queryus)>0)
        {
            $errorMessage[] = 'Ce nom d\'utilisateur est déjà relié à un autre compte';
        }

        $queryem = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($queryem)>0)
        {
            $errorMessage[] = 'Cet email est déjà relié à un autre compte';
        }

        else
{
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $success = "Bravo, votre compte est créé.\n";

    require_once 'DBconfig.php';

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (count($errorMessage)==0)
    {
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email');";
    mysqli_query($con, $sql);
    }
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
        <div id="signup">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-white">Créer un compte</h3>
                                <div class="form-group">
                                    <label for="lastname" class="text-white">Nom :</label><br>
                                    <input type="text" name="lastname" id="lastname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="firstname" class="text-white">Prénom :</label><br>
                                    <input type="text" name="firstname" id="firstname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="text-white">Nom d'utilisateur :</label><br>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="text-white">Email :</label><br>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-white">Mot de passe :</label><br>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-white">Confirmer le mot de passe :</label><br>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                                <div class="submit">
                                    <input type="submit" name="valide" class="btn btn-info btn-md" value="Valider">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <?php if ($errorMessage): ?> <div class="alert alert-danger"><?php echo implode("<br>", $errorMessage) ?></div>
                <?php elseif ($success): ?><div class="alert alert-success"><?= $success ?></div>
                <?php endif ?>
            </div>
        </div>
        <?php require 'includes/layouts/footer-inc.php'; ?>
    </body>
</html>