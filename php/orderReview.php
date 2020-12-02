<?php

function capitalize_str($param_str) {
    // Function which returns the given string capitalized on its first letter, lowercase on all others
    return ucwords(strtolower($param_str));
}

function sanitize_entry($param_str) {
    // Function which returns its trimmed version, also replaced with "N/A" when it comes up empty
    $param_str = trim($param_str);
    return $param_str ? $param_str : "N/A";
}

// This entire block sets shown variables to POST field values
$shown_name = "ERR";
if (isset($_POST['checkoutNameFst']) && isset($_POST['checkoutNameLst'])) {
    $fname_str = capitalize_str($_POST['checkoutNameFst']);
    $lname_str = capitalize_str($_POST['checkoutNameLst']);
    $shown_name = sanitize_entry("$fname_str $lname_str");
}

$shown_addr1 = "ERR";
if (isset($_POST['address1'])) {
    $shown_addr1 = sanitize_entry(capitalize_str($_POST['address1']));
}

$shown_addr2 = "ERR";
if (isset($_POST['address2'])) {
    $shown_addr2 = sanitize_entry(capitalize_str($_POST['address2']));
}

$shown_city = "ERR";
if (isset($_POST['city'])) {
    $shown_city = sanitize_entry(capitalize_str($_POST['city']));
}

$shown_prov = "ERR";
if (isset($_POST['province'])) {
    $shown_prov = sanitize_entry(capitalize_str($_POST['province']));
}

$shown_postal = "ERR";
if (isset($_POST['postal'])) {
    $shown_postal = sanitize_entry(capitalize_str($_POST['postal']));
}

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
        <h1>Thank you for your order!</h1>
        <?php
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        ?>
        <br>
        <div class="row">
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
                <?php include 'php/cartItems.php'; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="js/animations.js"></script>
    <script src="js/obtainOrder.js"></script>
</body>

</html>