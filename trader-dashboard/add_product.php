<?php
include('session.php');
include('functions.php');
if (isset($_POST['add_product'])) {
    if (
        !empty($_POST['product_name'])
        && !empty($_POST['price'])
        && !empty($_POST['quantity'])
        && !empty($_POST['option'])
        && !empty($_POST['description'])
        && !empty($_POST['allergy'])
        && !empty($_POST['minimum'])
        && !empty($_POST['maximum'])
        && !empty($_FILES['file']['name'])
        && !empty($_POST['shop_option'])
        && !empty($_POST['unit'])
    ) {
        $product_name = strtoupper($_POST['product_name']);
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['option'];
        $description = strtoupper($_POST['description']);
        $allergy = strtoupper($_POST['allergy']);
        $minimum = $_POST['minimum'];
        $maximum = $_POST['maximum'];
        $product_status = '0';
        $added_date = date("d-m-Y");
        $shop_id = $_POST['shop_option'];
        $unit = $_POST['unit'];
        $image = $_FILES['file']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");
        $product = "'" . str_replace("'", "''", $product) . "'";
        $description = "'" . str_replace("'", "''", $description) . "'";
        $allergy = "'" . str_replace("'", "''", $allergy) . "'";
        if (in_array($imageFileType, $extensions_arr)) {

            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image)) {
                $product = unique_product_name($connection, $product_name);
                if (!empty($product)) {

                    if (!empty($shop_id)) {
                        $query = "insert into product (product_name,PRODUCT_DESCRIPTION,product_image,stock,price,product_status,allergy_information,min_order,max_order,shop_id,product_category_id,add_date,product_unit)
                          values(:name,:description,:image,:stock,:price,:status,:allergy,:minimum,:maximum,:shop_id,:category_id,to_date(:added_date,'DD/MM/YYYY'),:unit)";

                        $result = oci_parse($connection, $query);

                        oci_bind_by_name($result, ':name', $product_name);
                        oci_bind_by_name($result, ':description', $description);
                        oci_bind_by_name($result, ':image', $image);
                        oci_bind_by_name($result, ':stock', $quantity);
                        oci_bind_by_name($result, ':price', $price);
                        oci_bind_by_name($result, ':status', $product_status);
                        oci_bind_by_name($result, ':allergy', $allergy);
                        oci_bind_by_name($result, ':minimum', $minimum);
                        oci_bind_by_name($result, ':maximum', $maximum);
                        oci_bind_by_name($result, ':shop_id', $shop_id);
                        oci_bind_by_name($result, ':category_id', $category);
                        oci_bind_by_name($result, ':added_date', $added_date);
                        oci_bind_by_name($result, ':unit', $unit);

                        if (oci_execute($result)) {
                            $_SESSION['product_add_message'] = "Product added successfiully";
                            header('location: traderdash3.php');
                        }
                    }
                }
            }
        } else {
            $_SESSION['imAGE_extension'] = "This image extension does not support";
            header('location: traderdash3.php');
        }
    } else {
        $_SESSION['feild_empty_error'] = "All Field must be filled";
        header('location: traderdash3.php');
    }
}
?>