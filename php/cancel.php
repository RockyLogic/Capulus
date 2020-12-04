<?php
/**
 * cancel.php
 * 
 * This file represents the cancel page, which holds a prompt for an order ID to delete; whether the deletion was successful or not,
 * it can return feedback to the user based on output from cancelOrder.php
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
        <h1>Cancel Order</h1>
        <br>
        <div class="row">
            <div id="checkout-form-wrapper" class="col-12 col-lg-8">
                <!-- Order Cancel Form -->
                <form method="post" action="cancelOrder.php">
                    <div class="checkout-block-form">
                        <label for="cancelledID">Order ID</label><br>
                        <input type="text" name="cancelledID" id="cancelledID">
                        <?php
                        if (isset($_POST['cancel_success']) && isset($_POST['received_id'])) {
                            // If there was a cancel ID submission prior to this, it will display the success or failure of the order deletion
                            $received_id = $_POST['received_id'];
                            switch ($_POST['cancel_success']) {
                                case 'true':
                                    // When deletion succeeds, display a field success message
                                    echo "<div class='field-cancel field-success'>Order \"$received_id\" has been successfully cancelled.</div>";
                                    break;
                                case 'false':
                                    // When deletion fails, display a field error message
                                    echo "<div class='field-cancel field-error'>Order \"$received_id\" does not exist in the system.</div>";
                                    break;
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <!-- Proceed to cancelOrder page -->
                    <button type="submit" class="btn btn-success align-self-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>