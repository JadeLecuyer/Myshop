<div class="col g-4">
    <div class="card card-product">
        <div class="card-product__wrapper-img">
            <a href="viewproduct.php?id=<?= $product['id'] ?>"><img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="card-img-top card-product__img"></a>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="card-product__title mb-1">
                <a href="viewproduct.php?id=<?= $product['id'] ?>" class="card-title"><?= $product['name'] ?></a>
                <!-- <h6 class="card-subtitle text-muted text-uppercase small-text">Catégorie</h6> -->
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <p class="card-text"><?= $product['price'] ?>€</p>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3 card-product__cart-logo" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>