<?php
// This block loads in the database through MySQLi credentials and queries for all products which have positive inventory
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// This block uses query parameter `id` to extract a product's row by the ID column and store their column information in variables
$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id;";
$result = $mysqli->query($query);

$row = $result->fetch_assoc();
$name = $row["name"];
$description = $row["description"];
$price = $row["price"];
$img_url = $row["img_url"];
$inv = $row["inv"];

// This block formats & prints the item's information in the frontend, having its full image, name, price, inventory, description, and own "Add to Cart" button
$itemInfo = <<<EOD
<div class="col-12 col-lg-6 itemDisplayImage" style="background-image: url('$img_url');">

</div>
<div class=" col-12 col-lg-6 d-flex flex-column justify-content-center" style="padding: 0 50px;">
  <h1>$name</h1>
  <h4>$$price</h4>
  <br>
  <p>Only $inv left in stock</p>
  <p>$description</p>
  <br>
  <br>
  <button onClick="addItem(this.id)" id="$id" class="btn btn-success" style="width:100%; margin-bottom: 20px;">Add To Cart</button>
</div>
EOD;
print($itemInfo);

// Close the MySQLi connection
$mysqli->close();

?>
