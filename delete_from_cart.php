<?php
include('session.php');
include('connection.php');
if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_GET['user'];

    $query = "delete from cart where product_id=$product_id and user_id=$user_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        if (oci_num_rows($result) != false) {
            $_SESSION['cart_remove_message'] = "Removed Successfully.";
            header("location: shopcart.php");
        }
    }
}
?>