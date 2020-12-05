<?php
/**
 * checkout.php
 *
 * This file represents the checkout page, holding the checkout form & cart summary, precedes the billing page
 */
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
                <img src="images/store.png" alt="Store logo" width="50" height="50" class="d-inline-block align-top" style="margin-right: 10px;">
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
                        <a onclick="window.location.href='./cart.php'" class="btn blueBtn nav-item nav-link " href="./cart.php">Cart <i class="fas fa-shopping-cart"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <br>
        <br>
        <h1>Checkout</h1>
        <br>
        <div class="row">
            <div id="checkout-form-wrapper" class="col-12 col-lg-8">
                <!-- Checkout Form for user's general information -->
                <form method="post" action="billing.php" onsubmit="return valInputCheckoutWithPHP(['checkoutEmail', 'checkoutNameFst', 'checkoutNameLst', 'address1', 'address2', 'city', 'province', 'postal'])">
                    <div class="checkout-block-form">
                        <!-- Checkout block holding fields: email -->
                        <label for="checkoutEmail">Email</label><br>
                        <div>
                            <input type="text" name="checkoutEmail" id="checkoutEmail" placeholder="Email">
                            <div class="field-error">Enter a valid email.</div>
                        </div>
                    </div>
                    <table class="checkout-mult-form table table-borderless">
                        <!-- Checkout blocks side-by-side holding fields: first name, last name -->
                        <tbody>
                            <tr>
                                <td>
                                    <label for="checkoutNameFst">First Name</label>
                                    <div>
                                        <input type="text" name="checkoutNameFst" id="checkoutNameFst" placeholder="First Name">
                                        <div class="field-error">Enter a valid first name.</div>
                                    </div>
                                </td>
                                <td>
                                    <label for="checkoutNameLst">Last Name</label>
                                    <div>
                                        <input type="text" name="checkoutNameLst" id="checkoutNameLst" placeholder="Last Name">
                                        <div class="field-error">Enter a valid last name.</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="checkout-block-form">
                        <!-- Checkout block holding fields: address #1, address #2, city, province, postal code -->
                        <label for="address1">Address</label><br>
                        <div>
                            <input type="text" name="address1" id="address1" placeholder="Address">
                            <div class="field-error">Enter a valid primary address.</div>
                        </div>
                        <br>
                        <label for="address2">Address 2</label><span> (Optional)</span><br>
                        <div>
                            <input type="text" name="address2" id="address2" placeholder="Apartment or suite">
                            <div class="field-error">Enter a valid or empty secondary address.</div>
                        </div>
                        <br>
                        <label for="city">City</label><br>
                        <div>
                            <input type="text" name="city" id="city" placeholder="City">
                            <div class="field-error">Enter a valid city name.</div>
                        </div>
                        <br>
                        <label for="province">Province</label><br>
                        <div>
                            <input type="text" name="province" id="province" placeholder="Province">
                            <div class="field-error">Enter a valid province name.</div>
                        </div>
                        <br>
                        <label for="postal">Postal</label><br>
                        <div>
                            <input type="text" name="postal" id="postal" placeholder="Postal Code">
                            <div class="field-error">Enter a valid postal code.</div>
                        </div>
                    </div>
                    <br>
                    <!-- Proceed to billing page -->
                    <button type="submit" class="btn btn-success align-self-end">Billing</button>
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
