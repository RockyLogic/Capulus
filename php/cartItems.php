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
$query = "SELECT id, name, price, inv FROM products WHERE inv > 0;";
$result = $mysqli->query($query);

// This block displays all products which have matching IDs in the current POST parameters
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $prodct_id = strval($row["id"]);
    $prodct_name = $row["name"];
    $prodct_price = $row["price"];
    $cart_quantity = 0;
    $item_inv = $row["inv"];

    // Expects to find any POST parameters denoted as "_cart_product_id_{x}", where `x` is the product ID
    if (isset($_POST['_cart_prodct_id_' . $prodct_id])) {
      $cart_quantity = min($item_inv, $_POST['_cart_prodct_id_' . $prodct_id]); // To secure bought items not going over existing inventory
      $prodct_total = $prodct_price * $cart_quantity;
      $str_prodct_total = in_dollar_form($prodct_total);

      // Print the cart item if its product ID exists in both the database and POST parameters, and has positive inventory
      $preview = <<<CARTITEM
      <div class="cart-item d-flex">
          <div style="margin-right: 20px;">Qtny: $cart_quantity</div>
          <div class="flex-grow-1">$prodct_name</div>
          <div class="justify-self-end">$str_prodct_total</div>
      </div>
CARTITEM;
      print($preview);
    }
  }
}

// Close the MySQLi connection
$mysqli->close();

?>
