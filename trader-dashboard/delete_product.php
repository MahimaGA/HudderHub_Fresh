<?php
include('session.php');
include('connection.php');
include('functions.php');
if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
    $query = "update product set PRODUCT_STATUS='2' where product_id = $product_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        if (oci_num_rows($result) != false) {
            $_SESSION['deleted_message'] = "Deleted Successfully";
            header("location: traderdash4.php");
        }
    }
}
?>
