<?php
include('session.php');
include('connection.php');
if(isset($_POST['upload_image']))
{
 if(!empty($_FILES['file']['name']))
 {
    $image = $_FILES['file']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png","gif","svg");
    $userID = $_SESSION["user_id"];
    
    if( in_array($imageFileType,$extensions_arr) ){
      
      if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$image)){
        
        $query = "update hhf_user set user_photo = '$image' where user_id= $userID ";
        $result =oci_parse($connection,$query);
        if(oci_execute($result))
        {
         
            unset($_SESSION["user_image"]);
            $_SESSION["user_image"] = $image;
            header('location: customerdash1.php');
        }
     }
    }
    else{
        $_SESSION['image_extension']="This image extension does not support";
        header('location: customerdash1.php');
    }

 }
 else{
    $_SESSION['image_error']="Please, Select a image.";
    header('location: customerdash1.php');
 }
}
?>