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
        $product = "'" . str_replace("'", "''", $product) . "'";
        $description = "'" . str_replace("'", "''", $description) . "'";
        $discount_percent = $_POST["discount"];


        if (!empty($discount_percent)) {

            $check_discount_query = "SELECT COUNT(*) AS discount_count FROM discount WHERE DISCOUNT_ID = $product_id";
            $check_discount_result = oci_parse($connection, $check_discount_query);
            oci_execute($check_discount_result);
            $discount_count = oci_fetch_assoc($check_discount_result)['DISCOUNT_COUNT'];

            if ($discount_count > 0) {
                $update_discount_query = "UPDATE discount SET DISCOUNT_PERCENT = $discount_percent WHERE DISCOUNT_ID = $product_id";
                $update_discount_result = oci_parse($connection, $update_discount_query);
                oci_execute($update_discount_result);
            } else {
                $insert_discount_query = "INSERT INTO discount (DISCOUNT_ID, DISCOUNT_PERCENT) VALUES ($product_id, $discount_percent)";
                $insert_discount_result = oci_parse($connection, $insert_discount_query);
                oci_execute($insert_discount_result);
            }

            $update_product_discount_query = "UPDATE product SET DISCOUNT_ID = $product_id WHERE PRODUCT_ID = $product_id";
            $update_product_discount_result = oci_parse($connection, $update_product_discount_query);
            oci_execute($update_product_discount_result);
        }


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
                header("location: trader_product.php");
            }
        }

        $query = "SELECT * FROM product WHERE UPPER(PRODUCT_NAME)=$product AND PRODUCT_ID != $product_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            $total_result = 0;
            while (($row = oci_fetch_array($result)) != false) {
                ++$total_result;
            }
            if ($total_result == 0) {
                $update_query = "UPDATE product 
                                SET PRODUCT_NAME=$product, PRICE =$price, STOCK=$quantity, PRODUCT_CATEGORY_ID =$option,
                                PRODUCT_DESCRIPTION=$description, MIN_ORDER=$minimum, MAX_ORDER=$maximum, PRODUCT_IMAGE='$image'
                                WHERE PRODUCT_ID = $product_id";
                $update_result = oci_parse($connection, $update_query);
                if (oci_execute($update_result)) {
                    if (oci_num_rows($update_result) != false) {
                        $_SESSION['update_message'] = "Item updated Successfully";
                        header("location: traderdash4.php");
                    }
                }
            } else {
                $_SESSION["product_error_message"] = "Duplicate product name.";
                header("location: trader_product.php");
            }
        } else {
            $_SESSION['image_extension'] = "This image extension does not support";
            header('location: trader_product.php');
        }
    } else {
        $_SESSION['empty_message'] = "Fields with * must be filled.";
        header("location: trader_product.php");
    }
}
?>
