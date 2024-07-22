<?php
include('session.php');
include('connection.php');
include('trader_validation.php');
if (!empty($_GET['ttoken'])) {
    $token = $_GET['ttoken'];
    $fk = $_GET['fk'];

    $fullname = $_SESSION['hhf_user_fullname'];
    $gmail = $_SESSION['hhf_user_gmail'];
    $contact = $_SESSION['hhf_user_contact'];
    $message_to_admin = $_SESSION['hhf_message_toadmin'];
    $birthday = $_SESSION['hhf_user_birthday'];
    $shopname = $_SESSION['hhf_shopname'];
    $registration_no = $_SESSION['registration_no'];
    $location = $_SESSION['hhf_location'];
    $selling_point = $_SESSION['hhf_sellingPoint'];

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
Name: $fullname <br>
Gmail : $gmail <br>
Contact Number : $contact <br>
Date of Birth : $birthday <br>
What do you want to sell : $message_to_admin <br>
</p>


<h4> SHOP Details :</h4>
<p>
Shop Name : $shopname <br>
Registration Number : $registration_no <br>
Shop Location : $location <br>
What makes the shop unique : $selling_point <br>
</p>

<p>Click here to activate your account : http://localhost/hudderhub_fresh/admin_approval.php?approve=$approval&token=$token&fk=$fk</p>

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
        header("location: login.php");
    }
}
?>