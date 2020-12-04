<?php
/**
 * processOrder.php
 * 
 * This file represents the processOrder page, entirely used as a backend mechanism to send all form fields as POST parameters
 * to the orderReview page (instantly), deleting product cookies, and depleting inventory from the database
 */

/**
 * This function returns the given string, but using a trimmed and lower-case convention for the SQL "orders" table
 * 
 * @param {param_str} The string to sanitize
 * @returns {String} The sanitized string, trimmed and converted to lower-case
 */
function parse_col_val($param_str) {
    return strtolower(trim($param_str));
}

/**
 * This function parses a list as a collection of strings (using quotes) and non-strings (not using quotes), and returns it
 * 
 * @param {list} An array of objects to parse as a collection of strings and non-strings
 * @param {str_map} An array of boolean where the `i`th index of `str_map` represents a string at the `i`th index of `list`
 * @returns {String} The collection of strings and non-strings, all as a string and delimited by commas
 */
function parse_as_strlist($list, $str_map) {
    $ret = "";
    for ($index = 0; $index < count($list) - 1; $index++) {
        // At the `index`th index, concatenate the `list` value as a string or non-string, along with an ending comma
        if ($str_map[$index]) {
            $ret .= "'" . $list[$index] . "',";
        }
        else {
            $ret .= $list[$index] . ",";
        }
    }

    // This block concatenates the last index without the ending comma
    $l_index = count($list) - 1;
    if ($str_map[$l_index]) {
        $ret .= "'" . $list[$l_index] . "'";
    }
    else {
        $ret .= $list[$l_index];
    }

    // Return the final collection
    return $ret;
}

// This block loads in the database through MySQLi credentials
$mysqli = new mysqli("localhost", "id15434053_admin", "&D>mnej=iv6U*%#=", "id15434053_ecommerce_db");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// This block performs a row insertion of the POST's general & billing data into the "orders" table
$in_post = true;
$order_id = uniqid();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // `post_params` defines an array of expected IDs to receive from POST parameters, while `str_map`
    // denotes which of these POST parameters are meant to be parsed as a string in the final product
    $post_params = array('checkoutEmail', 'checkoutNameLst', 'checkoutNameFst', 'address1', 'address2', 'city', 'province', 'postal', 'paymentName', '_cardExpiry_m', '_cardExpiry_y', 'cardNumber', 'cardCVV', '_code');
    $str_map = array(true, true, true, true, true, true, true, true, true, false, false, true, true, true);

    // This block accumulates the `sql_params` array, which will hold all sanitized values of the POST parameters for row insertion into the database
    $sql_params = array();
    foreach ($post_params as $post_param) {
        if ($post_param[0] == '_') {
            // Preceding underscore ('_') in parameter names is for special meaning 
            switch ($post_param) {
                case '_cardExpiry_m':
                    // Push the sanitized month field of `cardExpiry` (Expects "mm/yy") to `sql_params`; i.e. everything before '/'
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
                    // Push the sanitized year field of `cardExpiry` (Expects "mm/yy") to `sql_params`; i.e. everything after '/'
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
                    // Push the PHP-generated order ID to `sql_params`; already provided as sanitized, therefore will never create an error
                    array_push($sql_params, $order_id);
                    break;
            }
        }
        else {
            // No preceding underscore denotes normal POST parameters which are meant to be extracted, sanitized and then pushed to `sql_params`
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
        // If all of the POST parameters & special cases meets the required fields for row insertion, insert the row into the `orders` table
        $sql_param_str_fields = parse_as_strlist($sql_params, $str_map);
        $sql = "INSERT INTO orders (email, lname, fname, addr1, addr2, city, province, postal, name_payment, card_exp_m, card_exp_y, card_num, card_cvv, code) VALUES ($sql_param_str_fields);";
        $mysqli->query($sql);

        // This block depletes bought items of order from database inventory
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
    }
}

// This block pops cart cookies into an array being used in the POST (so that they can be displayed)
$post_cart = array();
foreach ($_COOKIE as $prodct_id => $prodct_count) {
    if ($prodct_count > 0) {
        // Exact naming of "_cart_product_id_{x}", where `x` is the product ID, for cartItems.php to display them
        $post_cart['_cart_prodct_id_' . strval($prodct_id)] = $prodct_count;
    }

    // Unset this cookie given by product ID
    unset($_COOKIE[$prodct_id]); 
    setcookie($prodct_id, null, -1, '/'); 
}

// Close the MySQLi connection
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
        // Automatic form submission to orderReview, containing all parameters for the order review
        document.getElementById("toNextForm").submit();
    </script>
</body>