<?php
include('session.php');
include('connection.php');
if (isset($_POST['update_product'])) {
    if (
        !empty($_POST["product_name"])
        && !empty($_POST["price"])
        && !empty($_POST["quantity"])
        && !empty($_POST["option"])
        && !empty($_POST["description"])
        && !empty($_POST["minimum"])
        && !empty($_POST["maximum"])
        && !empty($_POST["id"])
        && !empty($_POST["unit"])
    ) {
        $product_id = $_POST["id"];
        $product = strtoupper($_POST["product_name"]);
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $unit = $_POST["unit"];
        $option = $_POST["option"];
        $description = strtoupper($_POST["description"]);
        $minimum = $_POST["minimum"];
        $maximum = $_POST["maximum"];
        $image = $_POST["image"];

        $product = "'" . str_replace("'", "''", $product) . "'"; //repeating quotes to avoid sql injestion (ending the query)
        $description = "'" . str_replace("'", "''", $description) . "'";

        if (!empty($_FILES['file']['name'])) {
            $image = $_FILES['file']['name'];
            $target_dir = "images/";
            $target_file = $target_dir . basename($image);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");
            $userID = $_SESSION["user_id"];

            if (in_array($imageFileType, $extensions_arr)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image)) {
                }
            } else {
                $_SESSION['image_extension'] = "This image extension does not support";
                header("location: admin_product.php");
                exit; 
            }
        }

        $query = "SELECT * FROM product WHERE UPPER(PRODUCT_NAME) = $product AND PRODUCT_ID != $product_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            $total_result = 0;
            while (($row = oci_fetch_array($result)) != false) {
                ++$total_result;
            }
            if ($total_result == 0) {
                $query = "UPDATE product 
                          SET PRODUCT_NAME = $product, PRICE = $price, STOCK = $quantity, PRODUCT_CATEGORY_ID = $option,
                          PRODUCT_DESCRIPTION = $description, MIN_ORDER = $minimum, MAX_ORDER = $maximum, PRODUCT_IMAGE = '$image'
                          WHERE PRODUCT_ID = $product_id";
                $result = oci_parse($connection, $query);
                if (oci_execute($result)) {
                    if (oci_num_rows($result) != false) {
                        $_SESSION['update_message'] = "Item updated Successfully";
                        header("location: admindash3.php");
                        exit;
                    }
                }
            } else {
                $_SESSION["product_error_message"] = "Duplicate product name.";
                header("location: admin_product.php");
                exit; 
            }
        } else {
            $_SESSION['image_extension'] = "This image extension does not support";
            header('location: admin_product.php');
            exit;
        }
    } else {
        $_SESSION['empty_message'] = "Field with * must be filled.";
        header("location: admin_product.php");
        exit; 
    }
}
?>
