<?php
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // dba_handlers post data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $topic = $_POST['topic'];
    $description = $_POST['details'];
    $sql = "INSERT INTO contactForm(name, email, topic, description)
    VALUES ('$name', '$email', '$topic', '$description')";

    $mysqli->query($sql);
}

$mysqli->close();

?>
