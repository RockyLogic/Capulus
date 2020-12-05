<?php

// This block loads in the database through MySQLi credentials and queries for all products which have positive inventory
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
$query = "SELECT name, img_url, id, inv FROM products WHERE inv > 0;";
$result = $mysqli->query($query);

// This block displays all positive-inventory products which are in the database
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $name = $row["name"];
    $img_url = $row["img_url"];
    $id = $row["id"];
    $inv = $row["inv"];

    // For each product, its image, title, "View" and "Add" buttons are displayed and formatted correctly on the frontend
    $preview = <<<EOD
      <div class="shop-item-box col-12 col-md-6 col-lg-4">
        <div class="shop-item" style="background-image: url('$img_url');">
          <h5 class="shop-item-title">$name</h5>
          <button onClick="viewItem(this.id, $inv)" id="v$id" class="btn btn-info" style="bottom:5%; right:45%; position: absolute;">View</button>
          <button onClick="addItem(this.id, $inv)" id="$id" class="btn btn-success" style="bottom:5%; right:10%; position: absolute;">Add To Cart</button>
        </div>
      </div>
EOD;
    print($preview);
  }
}

// Close the MySQLi connection
$mysqli->close();

?>
