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

$prodct_price_sum = 0;
if ($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $prodct_id = $row["id"];
    $prodct_name = $row["name"];
    $prodct_price = $row["price"];
    $cart_quantity = 0;
    if (isset($_COOKIE[$prodct_id])) {
      $cart_quantity = $_COOKIE[$prodct_id];
      $prodct_total = $prodct_price * $cart_quantity;
      $str_prodct_total = in_dollar_form($prodct_total);
      $prodct_price_sum += $prodct_total;


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

?>
