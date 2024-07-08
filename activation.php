<?php
include("session.php");
include("connection.php");
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $updatequery = "update hhf_user set status='1' where verification_code='$token'";
    $stid = oci_parse($connection, $updatequery);

    if (oci_execute($stid)) {
        $_SESSION["mail_sent_message"] = "Account Activated successfully.";
        header("location:login.php");
    }
}
?>