<?php
/**
 * cart.php
 *
 * This file represents the cart page, holding the cart products from the cookies & cart summary, precedes the checkout page
 */

/**
 * This function returns the given number in dollar form: with 2 decimal places and a preceding dollar sign ('$').
 *
 * @param {param_val} The number to convert to dollar form
 * @returns {String} The dollar form representation of `param_val`
 */
function in_dollar_form($param_val) {
    return '$' . number_format((float)$param_val, 2, '.', '');
}

// This block loads in the database through MySQLi credentials and queries for all products which have positive inventory
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
$query = "SELECT id, name, price, inv FROM products WHERE inv > 0;";
$result = $mysqli->query($query);

// Initializing product details (of 5-arrays having quantity, title, total, ID, and inventory), subtotal and shipping variables
$prodct_details = array();
$prodct_price_sum = 0;
$prodct_price_shipping = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prodct_id = $row["id"];
        $prodct_name = $row["name"];
        $prodct_price = $row["price"];
        $cart_quantity = 0;
        $item_inv = $row["inv"];

        if (isset($_COOKIE[$prodct_id]) && $_COOKIE[$prodct_id] > 0) {
            // For each product whose ID matches with cart items' IDs (from the cookies), add to the subtotal and shipping
            $cart_quantity = min($_COOKIE[$prodct_id], $item_inv);
            $prodct_total = $prodct_price * $cart_quantity;
            $prodct_price_sum += $prodct_total;
            $prodct_price_shipping += 1.00 * $cart_quantity;

            // Push the product's properties to the `prodct_details` array
            array_push($prodct_details, array($cart_quantity, $prodct_name, $prodct_total, $prodct_id, $item_inv));
        }
    }
}

// Calculating the HST taxes (`prodct_price_taxes`) and total (`prodct_price_total`)
$prodct_price_taxes = 0.13 * $prodct_price_sum;
$prodct_price_total = $prodct_price_sum + $prodct_price_taxes + $prodct_price_shipping;

// For displaying purposes, have all of the subtotal, taxes, shipping, and total in dollar forms
$str_price_sum = in_dollar_form($prodct_price_sum);
$str_price_taxes = in_dollar_form($prodct_price_taxes);
$str_price_shipping = in_dollar_form($prodct_price_shipping);
$str_price_total = in_dollar_form($prodct_price_total);

// Close the MySQLi connection
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/6744a003bb.js"></script>
        <link rel="shortcut icon" href="images/store.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/nav.css">
        <title>Capulus</title>
    </head>

    <body>
        <nav id="navbar" class="navbar navbar-light navbar-expand-md" style="padding: 30px 1rem;">
            <div class="container">
                <a id="navbar-logo" class="navbar-brand d-flex align-items-center" target="_blank" href="./index.html">
                    <img src="images/store.png" alt="Store Logo" width="50" height="50" class="d-inline-block align-top" style="margin-right: 10px;">
                    <h3 id="navbar-title" style="font-weight: 600;"> Capulus</h3>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav navbar-pages">
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="./index.html" style="font-weight: 600;">Welcome</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="./shop.html" style="font-weight: 600;">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="./about.html" style="font-weight: 600;">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="./contact.html" style="font-weight: 600;">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a style="margin-left:30px;" onclick="window.location.href='./cart.php'" class="btn blueBtn nav-item nav-link " href="./cart.php">Cart <i class="fas fa-shopping-cart"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <br>
            <br>
            <h1>Cart</h1>
            <br>
            <section id="cart">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <!-- Cart Listing Block (Includes the quantity, title, total, along with interactions of ID and inventory for add/remove from cart) -->
                        <?php
                        foreach ($prodct_details as $prodct_detail) {
                            // For displaying a single block of one product
                            $summed_prodcts_price = in_dollar_form($prodct_detail[2]);
                            echo "
                            <div class='cart-item d-flex'>
                                <div class='align-self-center' style='margin-right: 20px;'>Qtny: $prodct_detail[0]</div>
                                <div class='flex-grow-1 align-self-center'>$prodct_detail[1]</div>
                                <div class='justify-self-end align-self-center'>$summed_prodcts_price</div>
                                <button type='button' onclick='removeFromCart($prodct_detail[3], $prodct_detail[4])' class='btn btn-success btn-xs align-self-center cart-minus-btn'>-</button>
                                <button type='button' onclick='addToCart($prodct_detail[3], $prodct_detail[4])' class='btn btn-success btn-xs align-self-center cart-plus-btn'>+</button>

                            </div>";
                        }
                        ?>
                    </div>
                    <div class="col-12 col-lg-4" style="margin-block-end: auto;">
                        <!-- Cart Summary Block -->
                        <div id="cart-summary" class="d-flex flex-column">
                            <h4 class="summary-title">Summary</h4>
                            <div class="d-flex flex-row">
                                <div class="flex-grow-1">Subtotal:</div>
                                <div><?php echo $str_price_sum; ?></div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="flex-grow-1">Taxes:</div>
                                <div><?php echo $str_price_taxes; ?></div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="flex-grow-1">Shipping:</div>
                                <div><?php echo $str_price_shipping; ?></div>
                            </div>
                            <hr class="summary-rule">
                            <div class="d-flex flex-row">
                                <div class="flex-grow-1">Total:</div>
                                <div><?php echo $str_price_total; ?></div>
                            </div>

                            <?php
                            if ($prodct_price_total > 0) {
                                // If there is something being bought, then enable the checkout button
                                echo "<button class=\"btn btn-success align-self-end\" style=\"position: absolute; bottom: 30%;\" onclick=\"window.location.href='checkout.php'\">Checkout</button>";
                            }
                            else {
                                // There are no items being bought, disabling the checkout button
                                echo "<button class=\"btn btn-success align-self-end\" style=\"position: absolute; bottom: 30%;\" disabled>Checkout</button>";
                            }
                            ?>
                        </div>
                        <div class="cancel-order-blurb">Looking to cancel an order? Click <a href="cancel.php">here.</a></div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="js/additional.js"></script>
    </body>
</html>
