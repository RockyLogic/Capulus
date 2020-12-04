<?php
/**
 * cancelOrder.php
 * 
 * This file represents the cancelOrder page, entirely used as a backend mechanism to send the success feedback of
 * order-cancelling as a POST parameter, and deletion of the order from database
 */

// Extracted cancel ID from POST parameters, sanitized by trimming
$in_cancel_id = trim($_POST["cancelledID"]);

// This block connects to the database and queries for the order code, deleting it if it exists
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// This block queries for and deletes the order with the given order ID, if possible; updates `cancel_success` on whether it succeeded
$cancel_success = 'false';
if (preg_match('/^[a-zA-Z0-9]+$/', $in_cancel_id)) {
    // Querying only for IDs with word-like characters
    $code_query = $mysqli->query("SELECT COUNT(*) AS found FROM orders WHERE code = '$in_cancel_id'");
    $found_code = $code_query->fetch_assoc()['found'];

    if ($found_code > 0) {
        // Only if found in the database, run query to delete the row with the cancel ID
        $deletion_query = "DELETE FROM orders WHERE code = '$in_cancel_id'";
        $mysqli->query($deletion_query);
        $cancel_success = 'true';
    }
}

// Close the MySQLi connection
$mysqli->close();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capulus - Cancelling Order</title>
</head>

<body>
    <form id="toCancelPage" method="post" action="cancel.php">
        <!-- Returning whether the order cancel was successful, just for the user to know -->
        <input type='hidden' name='cancel_success' id='cancel_success' value='<?php echo "$cancel_success"; ?>'>
        <input type='hidden' name='received_id' id='received_id' value='<?php echo "$in_cancel_id"; ?>'>
    </form>
    <script>
        // Automatic form submission to cancel page, containing the success of the cancelled order and received ID
        document.getElementById("toCancelPage").submit();
    </script>
</body>