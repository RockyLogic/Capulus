<?php
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}


$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id;";
$result = $mysqli->query($query);

$row = $result->fetch_assoc();
$name = $row["name"];
$description = $row["description"];
$price = $row["price"];
$img_url = $row["img_url"];


$itemInfo = <<<EOD
  <div class="col-12 col-lg-6 itemDisplayImage" style="background-image: url('$img_url');">

  </div>
  <div class=" col-12 col-lg-6 d-flex flex-column justify-content-center" style="padding: 0 50px;">
    <h1>$name</h1>
    <h4>$$price</h4>
    <br>
    <h4>Description</h4>
    <p>$description</p>
    <br>
    <br>
      <button onClick="addItem(this.id)" id="$id" class="btn btn-success" style="width:100%">Add To Cart</button>
    </div>
EOD;
    print($itemInfo);
?>
