<?php
include('session.php');
include('connection.php');
include('functions.php');
if (isset($_POST['edit_shop'])) {
  if (
    !empty($_POST['shopname'])
    && !empty($_POST['location'])
    && !empty($_POST['shop_id'])
  ) {
    $shopname = strtoupper($_POST['shopname']);
    $location = strtoupper($_POST['location']);
    $shop_id = $_POST['shop_id'];
    $image = $_POST['image'];
    if (!empty($_FILES['file']['name'])) {
      $image = $_FILES['file']['name'];
      $target_dir = "images/vendors/";
      $target_file = $target_dir . basename($image);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");
      $userID = $_SESSION["user_id"];

      if (in_array($imageFileType, $extensions_arr)) {

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image)) {
        }
      } else {
        $_SESSION['image_extension'] = "This image extension does not support";
        header("location: shop_update_form.php");
      }
    }


    $query = "select * from shop where UPPER(SHOP_NAME)='$shopname' and shop_id != $shop_id";
    $results = oci_parse($connection, $query);
    if (oci_execute($results)) {
      $total_result = 0;
      while (($row = oci_fetch_array($results)) != false) {
        ++$total_result;
      }
      if ($total_result == 0) {
        $query = "update shop set shop_name = '$shopname', shop_location ='$location',SHOP_LOGO ='$image' where SHOP_ID = $shop_id ";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
          if (oci_num_rows($result) != false) {
            unset($_SESSION["s_shop_id"]);
            unset($_SESSION["s_shop_name"]);
            unset($_SESSION["s_shop_location"]);
            unset($_SESSION["s_image"]);
            $_SESSION['update_message'] = "Shop updated Successfully";
            header("location: traderdash8.php");
          }
        }
      } else {
        $_SESSION['shopname_error'] = "This shop is already registered.";
        header('location: shop_update_form.php');
      }
    }
  } else {
    $_SESSION['empty_error'] = "Field with * must be filled.";
    header('location: shop_update_form.php');
  }
}
?>