<?php
include('session.php');
include('connection.php');
if (isset($_GET['approve'])) {
  $approve = $_GET['approve'];
  $reg = $_GET['reg'];


  if ($approve == "YES") {
    $query = "update shop set status = '1' where REGISTRATION_NO= $reg";
    $stid = oci_parse($connection, $query);
    if (oci_execute($stid)) {
      $_SESSION['shop_added'] = " Shop added successfully. ";
      echo $_SESSION['shop_added'];
    }
  }
}
?>