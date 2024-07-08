<?php
include('session.php');
include('connection.php');


if (isset($_GET['delete_from_wishlist']) && $_GET['delete_from_wishlist'] == 1) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION["user_id"];

    $query = "DELETE FROM WISHLIST WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':product_id', $product_id);
    oci_execute($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["id"])) {
        $id = $_POST["id"];
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : 1; 
        $user_id = $_SESSION["user_id"];
        $page = "productdetail.php?id=$id"; 
        if (!empty($_SESSION["username"])) {
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
                    $query = "INSERT INTO cart (product_id, user_id, product_quantity, purchase) 
                              VALUES (:product_id, :user_id, :quantity, 0)";
                    $stmt = oci_parse($connection, $query);
                    oci_bind_by_name($stmt, ':product_id', $id);
                    oci_bind_by_name($stmt, ':user_id', $user_id);
                    oci_bind_by_name($stmt, ':quantity', $quantity);
                    oci_execute($stmt);
                } else {
                    $query = "UPDATE cart SET product_quantity = product_quantity + :quantity 
                              WHERE product_id = :id AND user_id = :user_id AND purchase = 0";
                    $stmt = oci_parse($connection, $query);
                    oci_bind_by_name($stmt, ':quantity', $quantity);
                    oci_bind_by_name($stmt, ':id', $id);
                    oci_bind_by_name($stmt, ':user_id', $user_id);
                    oci_execute($stmt);
                }
                header("Location: $page"); 
                exit();
            } else {
                header("Location: $page");
            }
        } else {
            header("Location: login.php"); 
            exit();
        }
    } else {
        echo "Error: Product ID not provided.";
    }
} else {
    echo "Error: This page only accepts POST requests.";
}
?>
