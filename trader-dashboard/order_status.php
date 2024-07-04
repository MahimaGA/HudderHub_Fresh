
<?php

include('connection.php');
if (isset($_GET["id"])) {
    $order_id = $_GET["id"];
    $task = $_GET["task"];
    echo $task;
    if ($task == "delivered") {
        $query = "update user_order set ORDER_STATUS ='DELIVERED' where ORDER_ID = $order_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            if (oci_num_rows($result) != false) {
                header('location:traderdash2.php');
            }
        }
    }
    if ($task == 'processing') {
        $query = "update user_order set ORDER_STATUS ='PROCESSING' where ORDER_ID = $order_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            if (oci_num_rows($result) != false) {
                header('location:traderdash2.php');
            }
        }
    }
}
?>