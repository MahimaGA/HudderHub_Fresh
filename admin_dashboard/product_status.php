<?php
include('connection.php');

if (isset($_GET["id"]) && isset($_GET["task"])) {
    $product_id = $_GET["id"];
    $task = $_GET["task"];

    if ($task == "activate") {
        $query = "UPDATE product SET PRODUCT_STATUS = '1' WHERE PRODUCT_ID = $product_id";
    } elseif ($task == "deactivate") {
        $query = "UPDATE product SET PRODUCT_STATUS = '0' WHERE PRODUCT_ID = $product_id";
    }

    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        header('location:admindash3.php');
        exit();
    } else {
        echo "Error executing query: " . oci_error($result);
    }
} else {
    echo "Invalid request parameters";
}
?>