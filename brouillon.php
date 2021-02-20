<div class="table-responsive">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Produit</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $productsIds = array_keys($_SESSION['cart']);
                        $totalPrice = 0;
                        foreach($productsIds as $productId) {
                            $product = $userCart->getProduct($productId);
                            $totalPrice += floatval($product['price']);
                            echo '<tr>';
                            echo '<td><img src="' . $product['img'] . '" class="block-cart__product-img"></td>';
                            echo '<td>' . $product['name'] . '</td>' ;
                            echo '<td>' . $product['price'] . '€</td>' ;
                            echo '<td>
                                <a href="delete-from-cart.php?id=' . $product['id'] . '" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                </a>
                                </td>';
                            echo '</tr>' ;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Prix total</th>
                                <td colspan="2"><?= $totalPrice ?>€</td>
                            </tr>
                        </tfoot>
                </table>
            </div>