<?php
include('session.php');
include('connection.php');

if (isset($_GET["id"])) {
    $shop_id = $_GET["id"];
    $query = "update product set PRODUCT_STATUS='2' where shop_id = $shop_id";
    $result = oci_parse($connection, $query);
    oci_execute($result);

    $query = "update shop set STATUS='2' where SHOP_ID = $shop_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        if (oci_num_rows($result) != false) {
            header('location: traderdash8.php');
        }
    }
}
?>