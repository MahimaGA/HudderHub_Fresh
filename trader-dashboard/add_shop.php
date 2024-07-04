<?php
include('session.php');
include('connection.php');
include('functions.php');

if (isset($_POST['submit'])) {
    if (
        !empty($_POST['shop_name'])
        && !empty($_POST['location'])
        && !empty($_POST['pan'])
        && !empty($_FILES['file']['name'])
    ) {


        $image = $_FILES['file']['name'];
        $target_dir = "images/vendors/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");


        if (in_array($imageFileType, $extensions_arr)) {



            $shop_name = strtoupper($_POST['shop_name']);
            $location = strtoupper($_POST['location']);
            $pan = $_POST['pan'];
            $redirect = "traderdash7.php";


            if (shop_quantity($connection) == true) {
                $shop_quantity = shop_quantity($connection);
                $shopname = unique_shopname($connection, $shop_name, $redirect);
                if (!empty($shopname)) {

                    $registration = unique_pan($connection, $pan, $redirect);
                    if (!empty($registration)) {
                        $foreign_key = $_SESSION["user_id"];
                        $status = '0';
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image)) {
                            $sql = "insert into shop (shop_name,shop_location,registration_no,status,user_id,shop_logo)
             values(:shopname,:location,:registration,:status,:foreign,:logo)";
                            $results = oci_parse($connection, $sql);

                            oci_bind_by_name($results, ':shopname', $shopname);
                            oci_bind_by_name($results, ':location', $location);
                            oci_bind_by_name($results, ':registration', $registration);
                            oci_bind_by_name($results, ':status', $status);
                            oci_bind_by_name($results, ':foreign', $foreign_key);
                            oci_bind_by_name($results, ':logo', $image);
                            if (oci_execute($results)) {
                                $name = $_SESSION["name"];
                                $gmail = $_SESSION["email"];
                                $approval = "YES";
                                $to = "hudderhubfresh@gmail.com";
                                $subject = "ACCOUNT ACTIVATION";

                                $message = "
 <html>
 <head>
 <title>TRADER APPROVAL</title>
 </head>
 <body>
 <h1>TRADER - SHOP APPROVAL</h1>
 <h3>Approval required</h3>
 <h4> Trader Details :</h4>
 <p>
 Name: $name <br>
 Gmail : $gmail <br>
 
 </p>
 
 
 <h4> SHOP Details :</h4>
 <p>
 Shop Name : $shopname <br>
 Registration Number : $registration <br>
 Shop Location : $location <br>
 
 </p>
 
 <p>Click here to activate your account : http://localhost/HudderHub_Fresh/trader-dashboard/shop_activation.php?approve=$approval&reg=$registration</p>
 
 </body>
 </html>
 
 ";

                                $eol = PHP_EOL;

                                $header = "MIME-Version: 1.0" . $eol;
                                $header .= "Content-type:text/html;charset=UTF-8" . $eol;
                                $header .= "From: $gmail" . $eol;
                                $header .= "Reply-To: $gmail" . $eol;


                                $mail_sent = mail($to, $subject, $message, $header);
                                if ($mail_sent == true) {
                                    $_SESSION["trader_approval_message"] = "Your request is being processed.";
                                    header("location: traderdash7.php");
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $_SESSION['imAGE_extension'] = "This image extension does not support";
            header('location: traderdash7.php');
        }
    } else {
        $_SESSION['empty_error'] = "Field with * must be filled";
        header('location: traderdash7.php');
    }
}
?>