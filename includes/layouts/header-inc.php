<header class="header mb-5">
    <div class="header__band d-none d-md-block <?= (isset($_SESSION['username'])) ? 'header__band--bigger' : '' ?>">
        <?php if(isset($_SESSION['username'])) {
            echo '<div class="container"><span class="w-100 d-inline-block text-white text-end">Bonjour ' . $_SESSION['username'] .' ! Vous êtes connecté(e)</span></div>';
        } ?>
    </div>

    <nav class="navbar navbar-expand-md p-0">
        
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="/assets/img/logo.png" alt="Brand logo" class="header__logo">
            </a>

            <button class="navbar-light navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex justify-content-between text-uppercase header__nav-wrapper">
                    <ul class="navbar-nav mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link header__nav-link <?= ($currentPage === 'index') ? 'active' : '' ?>" href="index.php">Boutique</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-md-0">
                        <?php if (isset($_SESSION['id']) && $_SESSION['admin'] === '1') { ?>
                            <li class="nav-item">
                                <a class="nav-link header__nav-link <?= (in_array($currentPage, ['admin', 'delete', 'edit-user', 'edit-product', 'edit-category'])) ? 'active' : '' ?>" href="admin.php">Administration</a>
                            </li>
                        <?php } 
                            if(isset($_SESSION['username']))
                            {
                                echo '<li class="nav-item">
                                    <a class="nav-link header__nav-link" href="logout.php">Se déconnecter</a>
                                    </li>';
                            }
                            else
                            { ?>
                                  <li class="nav-item">
                                    <a class="nav-link header__nav-link <?= ($currentPage === 'signup') ? 'active' : '' ?>" href="signup.php">S'inscrire</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link header__nav-link <?= ($currentPage === 'signin') ? 'active' : '' ?>" href="signin.php">Se connecter</a>
                                    </li>
                            <?php } ?>
                    </ul>
                </div>
            </div>
                
        <a class="position-absolute link-dark header__cart" href="user-cart.php">
            <div class="position-relative">
                <div class="header__cart-number"><?=(isset($_SESSION['cart'])) ? count($_SESSION['cart']) : '0'?></div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3 header__cart-logo" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
            </div>
        </a>
        </div>
    </nav>
</header>
