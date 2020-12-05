<?php
/**
 * orderReview.php
 *
 * This file represents the orderReview page, which holds general form information (including the order ID) and bought items
 */

/**
 * This function returns the given string capitalized but lower-case throughout all characters after the first
 *
 * @param {param_str} The string to capitalize
 * @returns {String} The capitalized string, all lower-case except for the first character of the string
 */
function capitalize_str($param_str) {
    return ucwords(strtolower($param_str));
}

/**
 * This function returns its trimmed version, also replaced with "N/A" when it comes up empty
 *
 * @param {param_str} The string to trim
 * @returns {String} The trimmed string, or "N/A" if its trimmed version is empty
 */
function sanitize_entry($param_str) {
    $param_str = trim($param_str);
    return $param_str ? $param_str : "N/A";
}

// This entire block sets shown variables to POST field values
$shown_name = $shown_addr1 = $shown_addr2 = $shown_city = $shown_prov = $shown_postal = $shown_orderid = "ERR";
if (isset($_POST['checkoutNameFst']) && isset($_POST['checkoutNameLst'])) {
    // Assign first & last names to `fname_str` & `lname_str`, then full name to `shown_name`
    $fname_str = capitalize_str($_POST['checkoutNameFst']);
    $lname_str = capitalize_str($_POST['checkoutNameLst']);
    $shown_name = sanitize_entry("$fname_str $lname_str");
}
if (isset($_POST['address1'])) {
    // Assign `shown_addr1` with the address #1 field
    $shown_addr1 = sanitize_entry(capitalize_str($_POST['address1']));
}
if (isset($_POST['address2'])) {
    // Assign `shown_addr2` with the address #2 field
    $shown_addr2 = sanitize_entry(capitalize_str($_POST['address2']));
}
if (isset($_POST['city'])) {
    // Assign `shown_city` with the city field
    $shown_city = sanitize_entry(capitalize_str($_POST['city']));
}
if (isset($_POST['province'])) {
    // Assign `shown_prov` with the province field
    $shown_prov = sanitize_entry(capitalize_str($_POST['province']));
}
if (isset($_POST['postal'])) {
    // Assign `shown_postal` with the postal field
    $shown_postal = sanitize_entry(strtoupper($_POST['postal']));
}
if (isset($_POST['orderid'])) {
    // Assign `shown_postal` with the order ID field
    $shown_orderid = $_POST['orderid'];
}

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
        <h1>Thank you for your order!</h1>
        <!-- Show order ID -->
        <h4>Your order ID is: <b><?php echo "$shown_orderid"; ?></b></h4>
        <br>
        <div class="row">
            <!-- Order Info block which displays all of name, address #1, address #2, city, province, and postal code -->
            <div id="orderInfo" class="col-12 col-lg-6 slideRight" style="margin-bottom: 20px;">
                <h5>Name:</h5>
                <div id="name-field"><?php echo $shown_name ?></div>
                <br>
                <h5>Address 1:</h5>
                <div id="address1-field"><?php echo $shown_addr1 ?></div>
                <br>
                <h5>Address 2: </h5>
                <div id="address2-field"><?php echo $shown_addr2 ?></div>
                <br>
                <h5>City: </h5>
                <div id="city-field"><?php echo $shown_city ?></div>
                <br>
                <h5>Province: </h5>
                <div id="province-field"><?php echo $shown_prov ?></div>
                <br>
                <h5>Postal Code: </h5>
                <div id="postal-field"><?php echo $shown_postal ?></div>
            </div>
            <div class="col-12 col-lg-6 slideLeft" style="overflow-y: scroll; height: 60vh;">
                <!-- Display final items from cart, gathered from POST parameters (since cookies are gone, it must be from POST parameters) -->
                <?php include 'php/cartItems.php'; ?>
            </div>
            <div class="cancel-order-blurb" style="margin-top: 50;">Looking to cancel an order? Click <a href="cancel.php">here.</a></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="js/animations.js"></script>
</body>

</html>
