
<?php

include('connection.php');
if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
    $task = $_GET["task"];
    echo $task;
    if ($task == "active") {
        $query = "update product set PRODUCT_STATUS ='1' where PRODUCT_ID = $product_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            if (oci_num_rows($result) != false) {
                header('location:traderdash4.php');
            }
        }
    }
    if ($task == 'deactive') {
        $query = "update product set PRODUCT_STATUS ='0' where PRODUCT_ID = $product_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            if (oci_num_rows($result) != false) {
                header('location:traderdash4.php');
            }
        }
    }
}
?>