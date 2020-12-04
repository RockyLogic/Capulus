<?php

function parse_col_val($param_str) {
    // Function which returns a parsed string, keeping a trimmed and lower-case convention in the SQL "orders" table
    return strtolower(trim($param_str));
}

function parse_as_strlist($list, $str_map) {
    // Function which parses a list as a string list, where any string elements are put in quotes, and returns it
    $ret = "";
    for ($index = 0; $index < count($list) - 1; $index++) {
        if ($str_map[$index]) {
            $ret .= "'" . $list[$index] . "',";
        }
        else {
            $ret .= $list[$index] . ",";
        }
    }
    $l_index = count($list) - 1;
    if ($str_map[$l_index]) {
        $ret .= "'" . $list[$l_index] . "'";
    }
    else {
        $ret .= $list[$l_index];
    }
    return $ret;
}

// This block performs a row insertion into the "orders" table
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

$in_post = true;
$order_id = uniqid();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    /*
    // POST general & billing data to orders
    */
    $post_params = array('checkoutEmail', 'checkoutNameLst', 'checkoutNameFst', 'address1', 'address2', 'city', 'province', 'postal', 'paymentName', '_cardExpiry_m', '_cardExpiry_y', 'cardNumber', 'cardCVV', '_code');
    $str_map = array(true, true, true, true, true, true, true, true, true, false, false, true, true, true);
    $sql_params = array();
    foreach ($post_params as $post_param) {
        if ($post_param[0] == '_') {
            // Only for special meanings
            switch ($post_param) {
                case '_cardExpiry_m':
                    if (isset($_POST['cardExpiry'])) {
                        $sep_index = strpos($_POST['cardExpiry'], '/');
                        $extracted_m = trim(substr($_POST['cardExpiry'], 0, $sep_index));
                        array_push($sql_params, intval($extracted_m));
                    }
                    else {
                        $in_post = false;
                    }
                    break;
                case '_cardExpiry_y':
                    if (isset($_POST['cardExpiry'])) {
                        $sep_index = strpos($_POST['cardExpiry'], '/');
                        $extracted_y = trim(substr($_POST['cardExpiry'], $sep_index + 1));
                        array_push($sql_params, intval($extracted_y));
                    }
                    else {
                        $in_post = false;
                    }
                    break;
                case '_code':
                    array_push($sql_params, $order_id);
                    break;
            }
        }
        else {
            // Extract values from POST parameters
            if (isset($_POST[$post_param])) {
                array_push($sql_params, parse_col_val($_POST[$post_param]));
            }
            else {
                $in_post = false;
                break;
            }
        }
    }
    if ($in_post) {
        // If the POST parameters meets all the required fields, insert the row into the orders table
        $sql_param_str_fields = parse_as_strlist($sql_params, $str_map);
        $sql = "INSERT INTO orders (email, lname, fname, addr1, addr2, city, province, postal, name_payment, card_exp_m, card_exp_y, card_num, card_cvv, code) VALUES ($sql_param_str_fields);";
        $mysqli->query($sql);
    }
}

// Deplete bought items of order from database inventory
$query = "SELECT * FROM products WHERE inv > 0;";
$result = $mysqli->query($query);

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $prodct_id = $row["id"];
        $item_inv = $row["inv"];

        if (isset($_COOKIE[$prodct_id]) && $_COOKIE[$prodct_id] > 0) {
            $new_inv = max($item_inv - $_COOKIE[$prodct_id], 0);
            $update = "UPDATE products SET inv = $new_inv WHERE id = $prodct_id";
            mysqli_query($mysqli, $update);
        }
    }
}

// Pop cart cookies into an array being used in the POST (so that they can be displayed)
$post_cart = array();
foreach ($_COOKIE as $prodct_id => $prodct_count) {
    if ($prodct_count > 0) {
        $post_cart['_cart_prodct_id_' . strval($prodct_id)] = $prodct_count;
    }
    unset($_COOKIE[$prodct_id]); 
    setcookie($prodct_id, null, -1, '/'); 
}

$mysqli->close();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capulus - Processing Order</title>
</head>

<body>
    <form id="toNextForm" method="post" action="orderReview.php">
        <?php
        foreach ($_POST as $form_key => $form_val) {
            // Expected to echo out all fields and their values from checkout.php; form submission relies on this
            echo "<input type='hidden' name='$form_key' id='$form_key' value='$form_val'>";
        }
        foreach ($post_cart as $prodct_key => $prodct_quant) {
            // Use extracted product ID & quantity from cookies in POST
            echo "<input type='hidden' name='$prodct_key' id='$prodct_key' value='$prodct_quant'>";
        }
        ?>
        <input type='hidden' name='orderid' id='orderid' value='<?php echo "$order_id"; ?>'>
    </form>
    <script>
        document.getElementById("toNextForm").submit();
    </script>
</body>