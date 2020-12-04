<?php
// This block loads in the database through MySQLi credentials
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// This block uses POST parameters from the form to insert into the contactForm table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // dba_handlers post data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $topic = $_POST['topic'];
    $description = $_POST['details'];

    // Performing the insertion query from POST parameters
    $sql = "INSERT INTO contactForm(name, email, topic, description)
    VALUES ('$name', '$email', '$topic', '$description')";
    $mysqli->query($sql);
}

// Close the MySQLi connection
$mysqli->close();

?>
