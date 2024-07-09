<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('session.php');
include('connection.php');

if (!empty($_SESSION["username"])) {
    if(isset($_GET['delete_from_wishlist']) && $_GET['delete_from_wishlist'] == 1) {
        $product_id = $_GET['id'];
        $user_id = $_SESSION["user_id"];
        $query = "DELETE FROM WISHLIST WHERE user_id = $user_id AND product_id = $product_id";
        $result = oci_parse($connection, $query);
        oci_execute($result);
    }
    
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $page = $_GET["page"];
        $user_id = $_SESSION["user_id"];
        $query_stock = "SELECT stock FROM product WHERE product_id = :id";
        $stmt_stock = oci_parse($connection, $query_stock);
        oci_bind_by_name($stmt_stock, ':id', $id);
        oci_execute($stmt_stock);
        $row_stock = oci_fetch_assoc($stmt_stock);
        $stock_quantity = $row_stock['STOCK'];

        if ($stock_quantity > 1) { 
            $query = "SELECT COUNT(*) FROM cart WHERE product_id = :id AND user_id = :user_id AND purchase = 0";
            $stmt = oci_parse($connection, $query);
            oci_bind_by_name($stmt, ':id', $id);
            oci_bind_by_name($stmt, ':user_id', $user_id);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            $counter = $row['COUNT(*)'];

            if ($counter == 0) {
                $quantity = 1; 
                $purchase = 0;
                $query = "INSERT INTO cart (product_id, user_id, product_quantity, purchase) 
                          VALUES (:product_id, :user_id, :quantity, :purchase)";
                $stmt = oci_parse($connection, $query);
                oci_bind_by_name($stmt, ':product_id', $id);
                oci_bind_by_name($stmt, ':user_id', $user_id);
                oci_bind_by_name($stmt, ':quantity', $quantity);
                oci_bind_by_name($stmt, ':purchase', $purchase);
                oci_execute($stmt);
            } else {
                $query = "UPDATE cart SET product_quantity = product_quantity + 1 
                          WHERE product_id = :id AND user_id = :user_id AND purchase = 0";
                $stmt = oci_parse($connection, $query);
                oci_bind_by_name($stmt, ':id', $id);
                oci_bind_by_name($stmt, ':user_id', $user_id);
                oci_execute($stmt);
            }
            header("Location: $page");
            exit();
        } else {
            header("Location: $page");
            exit();
        }
    }
} else {
    header('location: login.php');
    exit;
}
?>
