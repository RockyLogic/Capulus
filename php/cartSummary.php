<?php
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
$query = "SELECT id, name, price, inv FROM products;";
$result = $mysqli->query($query);

// Initializing subtotal and shipping variables
$prodct_price_sum = 0;
$prodct_price_shipping = 0;

// This block accumulates the cart summary's subtotal (`prodct_price_sum`) and shipping (`prodct_price_shipping`)
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $prodct_id = $row["id"];
        $prodct_name = $row["name"];
        $prodct_price = $row["price"];
        $cart_quantity = 0;
        $item_inv = $row["inv"];

        if (isset($_COOKIE[$prodct_id])) {
            // For each product whose ID matches with cart items' IDs (from the cookies), add to the subtotal and shipping
            $cart_quantity = min($item_inv, $_COOKIE[$prodct_id]);
            $prodct_total = $prodct_price * $cart_quantity;
            $prodct_price_sum += $prodct_total;
            $prodct_price_shipping += 1.00 * $cart_quantity;
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

// Print the final cart summary as a block in the frontend, ordered as "Subtotal, Taxes, Shipping | Total"
$summary = <<<SUMMARY
<div id="cart-summary" class="d-flex flex-column">
    <h4 class="summary-title">Summary</h4>
    <div class="d-flex flex-row">
        <div class="flex-grow-1">Subtotal:</div>
        <div>$str_price_sum</div>
    </div>
    <div class="d-flex flex-row">
        <div class="flex-grow-1">Taxes:</div>
        <div>$str_price_taxes</div>
    </div>
    <div class="d-flex flex-row">
        <div class="flex-grow-1">Shipping:</div>
        <div>$str_price_shipping</div>
    </div>
    <hr class="summary-rule">
    <div class="d-flex flex-row">
        <div class="flex-grow-1">Total:</div>
        <div>$str_price_total</div>
    </div>
</div>
SUMMARY;
print($summary);

// Close the MySQLi connection
$mysqli->close();

?>
