<?php
/**
 * billing.php
 * 
 * This file represents the billing page, holding the billing form & cart summary, precedes the processOrder page (which automatically redirects to the orderReview page)
 */
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
                        <button onclick="window.location.href='cart.php'" class="btn bluebtn nav-item nav-link" href="./cart.php">Cart <i class="fas fa-shopping-cart"></i></button>
                    </li>
                </ul>
            </div>
    </nav>

    <div class="container">
        <br>
        <br>
        <h1>Billing</h1>
        <br>
        <div class="row">
            <div id="checkout-form-wrapper" class="col-12 col-lg-8">
                <!-- Checkout Form for user's billing information -->
                <form method="post" action="processOrder.php" onsubmit="return (valInputBillingWithPHP(['paymentName', 'cardNumber', 'cardExpiry', 'cardCVV']) && valInputCheckoutWithPHP(['checkoutEmail', 'checkoutNameFst', 'checkoutNameLst', 'address1', 'address2', 'city', 'province', 'postal'], true))">
                    <div class="checkout-block-form">
                        <!-- Checkout block holding fields: billing name, card number, expiry date, CVV number -->
                        <label for="paymentName">Billing Name</label><br>
                        <div>
                            <input type="text" name="paymentName" id="paymentName" placeholder="Billing Name">
                            <div class="field-error">Enter a valid billing name.</div>
                        </div>
                        <br>
                        <label for="cardNumber">Card Number</label><br>
                        <div>
                            <input type="text" name="cardNumber" id="cardNumber" placeholder="Card Number">
                            <div class="field-error">Enter a valid card number.</div>
                        </div>
                        <br>
                        <label for="cardExpiry">Expiry Date (mm/yy)</label><br>
                        <div>
                            <input type="text" name="cardExpiry" id="cardExpiry" placeholder="MM/YY">
                            <div class="field-error">Enter a valid expiry date in format "mm/yy".</div>
                        </div>
                        <br>
                        <label for="cardCVV">CVV</label><br>
                        <div>
                            <input type="text" name="cardCVV" id="cardCVV" placeholder="CVV">
                            <div class="field-error">Enter a valid card CVV.</div>
                        </div>
                        <?php
                        foreach ($_POST as $form_key => $form_val) {
                            // Expected to echo out all fields and their values from checkout.php; form submission relies on this
                            echo "<input type='hidden' name='$form_key' id='$form_key' value='$form_val'>";
                        }
                        ?>
                    </div>
                    <br>
                    <!-- Proceed to billing page -->
                    <button type="submit" class="btn btn-success align-self-end">Order Now</button>
                </form>
            </div>
            <div class="col-12 col-lg-4">
                <!-- PHP-generated cart summary page, which uses cookies -->
                <?php include 'php/cartSummary.php'; ?>
            </div>
        </div>
    </div>
    <script src="js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>