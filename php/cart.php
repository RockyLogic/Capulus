<?php

function in_dollar_form($param_val) {
    return '$' . number_format((float)$param_val, 2, '.', '');
}

#Load the database
#Enter database credentials
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
$query = "SELECT id, name, price FROM products;";
$result = $mysqli->query($query);

$prodct_details = array();
$prodct_price_sum = 0;
$prodct_price_shipping = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prodct_id = $row["id"];
        $prodct_name = $row["name"];
        $prodct_price = $row["price"];
        $cart_quantity = 0;

        if (isset($_COOKIE[$prodct_id])) {
            $cart_quantity = $_COOKIE[$prodct_id];
            $prodct_total = $prodct_price * $cart_quantity;
            $prodct_price_sum += $prodct_total;
            $prodct_price_shipping += 1.00 * $cart_quantity;

            array_push($prodct_details, array($cart_quantity, $prodct_name, $prodct_total));
        }
    }
}

$prodct_price_taxes = 0.13 * $prodct_price_sum;
$prodct_price_total = $prodct_price_sum + $prodct_price_taxes + $prodct_price_shipping;

$str_price_sum = in_dollar_form($prodct_price_sum);
$str_price_taxes = in_dollar_form($prodct_price_taxes);
$str_price_shipping = in_dollar_form($prodct_price_shipping);
$str_price_total = in_dollar_form($prodct_price_total);
?>

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
                    <img src="../images/store.png" width="50px" height="50px" class="d-inline-block align-top" style="margin-right: 10px;">
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
                            <button onclick="window.location.href='cart.html'" class="btn bluebtn nav-item nav-link" href="./cart.html">Cart <i class="fas fa-shopping-cart"></i></button>
                        </li>
                    </ul>
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
                        <?php
                        foreach ($prodct_details as $prodct_detail) {
                            $summed_prodcts_price = in_dollar_form($prodct_detail[2]);
                            echo "
                            <div class='cart-item d-flex'>
                                <div style='margin-right: 20px;'>Qtny: $prodct_detail[0]</div>
                                <div class='flex-grow-1'>$prodct_detail[1]</div>
                                <div class='justify-self-end'>$summed_prodcts_price</div>
                            </div>";
                        }
                        ?>
                    </div>
                    <div class="col-12 col-lg-4" style="margin-block-end: auto;">
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

                            <button class="btn btn-success align-self-end" style="position: absolute; bottom: 10%;" onclick="window.location.href='checkout.php'">Checkout</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>