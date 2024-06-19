<?php
include('session.php');
include('connection.php');
if (isset($_POST['upload_image'])) {
   if (!empty($_FILES['file']['name'])) {
      $user_image = $_FILES['file']['name'];
      $target_dir = "images/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");
      $user_ID = $_SESSION["user_id"];

      if (in_array($imageFileType, $extensions_arr)) {

         if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $user_image)) {

            $query = "update HHF_USER set USER_PHOTO= '$user_image' where USER_ID= $user_ID ";
            $result = oci_parse($connection, $query);
            if (oci_execute($result)) {

               unset($_SESSION["user_image"]);
               $_SESSION["user_image"] = $user_image;
               header('location: admindash1.php');
            }
         }
      } else {
         $_SESSION['image_extension'] = "This image extension does not support";
         header('location: admindash1.php');
      }
   } else {
      $_SESSION['image_error'] = "Please, Select a image.";
      header('location: admindash1.php');
   }
}
?>