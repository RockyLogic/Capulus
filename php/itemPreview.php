<?php

#Load the database
#Enter database credentials
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
$query = "SELECT * FROM products WHERE inv > 0;";
$result = $mysqli->query($query);

if ($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $name = $row["name"];
    $img_url = $row["img_url"];
    $id = $row["id"];


    $preview = <<<EOD

      <div class="shop-item-box col-12 col-md-6 col-lg-4">
        <div class="shop-item" style="background-image: url('$img_url');">
          <h5 class="shop-item-title">$name</h5>
          <button onClick="viewItem(this.id)" id="$id" class="btn btn-info" style="bottom:5%; right:45%; position: absolute;">View</a>
          <button onClick="addItem(this.id)" id="$id" class="btn btn-success" style="bottom:5%; right:10%; position: absolute;">Add To Cart</button>
        </div>
      </div>

EOD;
    print($preview);
    }
  }

?>
