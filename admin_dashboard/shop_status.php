<?php
include('connection.php');
if (isset($_GET["id"]) && isset($_GET["task"])) {
    $shop_id = $_GET["id"];
    $task = $_GET["task"];

    if ($task == "activate") {
        $query = "UPDATE shop SET STATUS ='1' WHERE SHOP_ID = $shop_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            header('location: admindash6.php');
            exit(); 
        }
    } elseif ($task == 'deactivate') {
        $query = "UPDATE shop SET STATUS ='0' WHERE SHOP_ID = $shop_id";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            header('location: admindash6.php');
            exit(); 
        }
    } else {
        echo "Invalid task!";
    }
} else {
    echo "Missing parameters!";
}
?>