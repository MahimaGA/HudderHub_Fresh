<?php
include('session.php');
include('connection.php');
if (isset($_GET['approve'])) {
    $approve = $_GET['approve'];
    $token = $_GET['token'];
    $foreign_key = $_GET['fk'];

    if ($approve == "YES") {
        $updatequery = "UPDATE hhf_user SET status ='1' WHERE verification_code ='$token'";
        $stid = oci_parse($connection, $updatequery);

        if (oci_execute($stid)) {
            $query = "UPDATE shop SET status = '1' WHERE user_id='$foreign_key'";
            $stid = oci_parse($connection, $query);
            if (oci_execute($stid)) {
                unset($_SESSION["approved_confirm_message"]);
                header("location: login.php");
            }
        }
    } else {
        $_SESSION["approved_confirm_message"] = "Activation failed.";
        header("location:login.php");
    }
}
?>