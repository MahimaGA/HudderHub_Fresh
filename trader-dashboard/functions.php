<?php
include("session.php");
include("connection.php");

$_SESSION['email_error_message'] = "";
$_SESSION['password_error_message'] = "";

$_SESSION["username_error_message"] = "";
$_SESSION["mail_sent_message"] = "";
$_SESSION["invalid_credential_error_message"] = "";
$_SESSION["not_active_error_message"] = "";
$_SESSION["shopname_error_message"] = "";

function email_validation($email, $user_role)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        $_SESSION['email_error_message'] = "Invalid email address.";
        if ($user_role == 'C') {
            header("location: newregister.php");
        }
        if ($user_role == 'T') {
            header("location: traderregister.php");
        }
    }
}

function password_validation($password)
{  

    if (strlen($password) < 6) {
        $_SESSION['password_error_message'] = "Password length must be 6 or greater.";
        return false;
    } else {
        $pattern = '/[a-z\s]/i';
        $includes_alphabet = preg_match($pattern, $password);
        if ($includes_alphabet == 1) {
            $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            $includes_symbol = preg_match($pattern, $password);
            if ($includes_symbol == 1) {
                $includes_number = preg_match('~[0-9]~', $password);
                if ($includes_number == 1) {
                    return true;
                } else {
                    $_SESSION['password_error_message'] = "Password must contain at least one numeric character.";
                    return false;
                }
            } else {
                $_SESSION['password_error_message'] = "Password must contain at least one special character.";
                return false;
            }
        } else {
            $_SESSION['password_error_message'] = "Password must contain alphabetic character.";
            return false;
        }
    }
}

function unique_username($connection, $username, $user_role)
{
    $temp = $username;
    if (!$connection) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $query = "select user_name from HHF_USER where user_name='$temp'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);

    $total_result = 0;
    while (($row = oci_fetch_array($stid)) != false) {
        ++$total_result;
    }
    oci_free_statement($stid);
    oci_close($connection);
    if ($total_result == 0) {
        return $username;
    } else {
        $_SESSION["username_error_message"] = "This email address is already used.";

        if ($user_role == 'C') {
            header("location: newregister.php");
        }
        if ($user_role == 'T') {
            header("location: traderregister.php");
        }
    }
}

function gmail_verification($fullname, $gmail, $token)
{

    $to = $gmail;
    $subject = "ACTIVATION EMAIL";
    $message = "
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />


    <head>
        <link rel='stylesheet' href='emailstyle.css'>

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css'
            integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>


        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap'
            rel='stylesheet'>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300&family=Merriweather&family=Montserrat:wght@200;400&family=Poppins:wght@200&family=Sacramento&display=swap'
            rel='stylesheet'>
    </head>

<body>
    <!-- START OF EMAIL TEMP -->
    <div
        style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Josefin Sans', sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>
    </div>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>

        <tr>
            <td bgcolor='#b8d6ce' align='center'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                    </tr>
                </table>
            </td>
        </tr>
 <tr>
            <td bgcolor='#b8d6ce' align='center' style='padding: 0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='center' valign='top'
                            style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                            <h1
                                style='font-size: 35px;  margin: 2; font-family: 'Josefin Sans', sans-serif;'>
                                Welcome
                                <div class='name'>
                                    <span style='font-size: 20px;'> $fullname</span>

                                </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='center'>
                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; font-size: 17px;'>
                                We're excited to have you get started. First, you need to confirm your
                                account. Just press the button below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                    <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                    

                                              <span> http://localhost/HudderHub_Fresh/activation.php?token=$token</span>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor='#ffffff' align='center'>
                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; font-size: 17px;'  align='center'>

                                HudderHub Fresh lets you shop at various stores in your local area of Cleckhudderfaux. HudderHub Fresh focuses on delivering quality, fresh, organic food with a short supply chain, working directly with its local farms, dairies, fisheries, and other food partners. 
                                


                                 </p>

                            <p class='start-text' style='font-family: 'Josefin Sans'; margin-left: 60px; align='center'>
                                If you have any questions, just reply to hudderhubfresh@gmail.com, we're always happy
                                    to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left' margin-left: 40px; margin-right: 40px; >

                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; margin-left: 40px; margin-right: 40px; font-size: 17px;'>
                                Cheers, <br> HudderHub Fresh Team</p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>
</html>
";
    $eol = PHP_EOL;

    $header = "MIME-Version: 1.0" . $eol;
    $header .= "Content-type:text/html;charset=UTF-8" . $eol;
    $header .= "From: hudderhubfresh@gmail.com" . $eol;
    $header .= "Reply-To: hudderhubfresh@gmail.com" . $eol;


    $mail_sent = mail($to, $subject, $message, $header);
    if ($mail_sent == true) {
        $_SESSION["mail_sent_message"] = "Please, Check your gmail to activate your account $gmail";
        header("location: login.php");
    }
}

function keep_user_details($user_id, $full_name, $email, $user_password, $user_role, $contact_no, $created_date, $updated_date, $date_of_birth, $gender, $user_photo, $username)
{
    $_SESSION["user_id"] = $user_id;
    $_SESSION["name"] = $full_name;
    $_SESSION["email"] = $email;
    $_SESSION["user_password"] = $user_password;
    $_SESSION["user_role"] = $user_role;
    $_SESSION["contact"] = $contact_no;
    $_SESSION["Created_Date"] = $created_date;
    $_SESSION["Updated_Date"] = $updated_date;
    $_SESSION["birthdate"] = $date_of_birth;
    $_SESSION["gender"] = $gender;
    $_SESSION["user_image"] = $user_photo;
    $_SESSION["username"] = $username;

    switch ($user_role) {
        case 'C':
            header("location: index.php");
            exit;
        case 'T':
            header("location: trader-dashboard/traderdash1.php");
            exit;
        case 'A':
            header("location: admin_dashboard/admindash1.php");
            exit;
        default:
            $_SESSION["user_role"] = "Unknown";
            echo "Your account does not exist. Please Register";
            exit;
    }
}

function login_verification($connection, $username, $password)
{
    $hashed_password = md5($password);
    $query = "SELECT USER_ID, FULL_NAME, EMAIL, USER_PASSWORD, USER_ROLE, CONTACT_NO, CREATED_DATE, UPDATED_DATE, DATE_OF_BIRTH, GENDER, USER_PHOTO, STATUS, USERNAME FROM HHF_USER WHERE USERNAME = :username AND USER_PASSWORD = :password";
    $stid = oci_parse($connection, $query);
    if (!$stid) {
        $e = oci_error($connection);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_bind_by_name($stid, ":username", $username);
    oci_bind_by_name($stid, ":password", $hashed_password);
    $result = oci_execute($stid);
    if (!$result) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $row = oci_fetch_assoc($stid);
    if (!$row) {
        $_SESSION["invalid_credential_error_message"] = "Incorrect username or password. Please try again.";
        header("location: login.php");
        exit;
    }
    $_SESSION["user_id"] = $row["USER_ID"];
    $_SESSION["name"] = $row["FULL_NAME"];
    $_SESSION["email"] = $row["EMAIL"];
    $_SESSION["user_password"] = $row["USER_PASSWORD"];
    $_SESSION["user_role"] = $row["USER_ROLE"];
    $_SESSION["contact"] = $row["CONTACT_NO"];
    $_SESSION["Created_Date"] = $row["CREATED_DATE"];
    $_SESSION["Updated_Date"] = $row["UPDATED_DATE"];
    $_SESSION["birthdate"] = $row["DATE_OF_BIRTH"];
    $_SESSION["gender"] = $row["GENDER"];
    $_SESSION["user_image"] = $row["USER_PHOTO"];
    $_SESSION["username"] = $row["USERNAME"];

    if ($row["STATUS"] == 1) {
        switch ($row["USER_ROLE"]) {
            case 'C':
                header("location: index.php");
                exit;
            case 'T':
                header("location: trader-dashboard/traderdash1.php");
                exit;
            case 'A':
                header("location: admin_dashboard/admindash1.php");
                exit;
            default:
                echo "Unknown user role.";
                exit;
        }
    } else {
        $_SESSION["not_active_error_message"] = "You have not activated your account yet. Please check your email to activate your account.";
        header("location: login.php");
        exit;
    }
}




function unique_shopname($connection, $shopname, $redirect)
{
    $query = "select shop_name from shop where UPPER(shop_name)='$shopname'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);

    $total_result = 0;
    while (($row = oci_fetch_array($stid)) != false) {
        ++$total_result;
    }

    if ($total_result == 0) {

        return $shopname;
    } else {
        $_SESSION["shopname_error_message"] = "This shop is already registered.";
        if ($redirect == 'traderregister2.php') {
            header("location: traderregister2.php");
        }
        if ($redirect == 'traderdash7.php') {
            header('location: traderdash7.php');
        }
        if ($redirect == 'traderdash8.php') {
            header('location: traderdash8.php');
        }
    }
}


function unique_pan($connection, $pan, $redirect)
{

    if (!$connection) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $query = "select registration_no from shop where registration_no='$pan'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);

    $total_result = 0;
    while (($row = oci_fetch_array($stid)) != false) {
        ++$total_result;
    }
    oci_free_statement($stid);
    oci_close($connection);
    if ($total_result == 0) {
        return $pan;
    } else {
        $_SESSION["pan_error_message"] = "This shop is already registered.";
        if ($redirect == 'traderregister2.php') {
            header("location: traderregister2.php");
        } else {
            header('location: traderdash7.php');
        }
    }
}


function foreign_key($connection, $value)
{
    $query = "select user_id from HHF_USER where user_name='$value'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);

    while (($row = oci_fetch_array($stid)) != false) {
        $user_id = $row["USER_ID"];
    }
    if (!empty($user_id)) {
        return $user_id;
    }
}



function trader_gmail_verification($fullname, $gmail, $token, $foreign_key)
{

    $to = $gmail;
    $subject = "ACCOUNT ACTIVATION";

    $message = "
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />


    <head>
        <link rel='stylesheet' href='emailstyle.css'>

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css'
            integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>


        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap'
            rel='stylesheet'>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300&family=Merriweather&family=Montserrat:wght@200;400&family=Poppins:wght@200&family=Sacramento&display=swap'
            rel='stylesheet'>
    </head>

<body>
    <!-- START OF EMAIL TEMP -->
    <div
        style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Josefin Sans', sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>
    </div>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>

        <tr>
            <td bgcolor='#b8d6ce' align='center'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                    </tr>
                </table>
            </td>
        </tr>
 <tr>
            <td bgcolor='#b8d6ce' align='center' style='padding: 0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='center' valign='top'
                            style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                            <h1
                                style='font-size: 35px;  margin: 2; font-family: 'Josefin Sans', sans-serif;'>
                                Welcome
                                <div class='name'>
                                    <span style='font-size: 20px;'> $fullname</span>

                                </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='center'>
                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; font-size: 17px;'>
                                We're excited to have you get started. First, you need to confirm your
                                account. Just press the button below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                    <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                    

                                              <span> http://localhost/HudderHub_Fresh/trader_activation.php?ttoken=$token&fk=$foreign_key </span>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor='#ffffff' align='center'>
                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; font-size: 17px;'  align='center'>

                                HudderHub Fresh platform provides local traders to showcase their products into a whole new
                                marketplace, increasing their profits and bringing them to a wider spectrum of suburb
                                citizens. </p>
                            <br>
                        
<br>
                            <p class='start-text' style='font-family: 'Josefin Sans'; margin-left: 60px; align='center'>
                                If you have any questions, just reply to hudderhubfresh@gmail.com, we're always happy
                                    to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'>

                            <p class='start-text'
                                style='font-family: 'Josefin Sans'; margin-left: 40px; margin-right: 40px; font-size: 17px;'>
                                Cheers, <br> HudderHub Fresh Team</p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>
</html>

";

    $eol = PHP_EOL;

    $header = "MIME-Version: 1.0" . $eol;
    $header .= "Content-type:text/html;charset=UTF-8" . $eol;
    $header .= "From: hudderhubfresh@gmail.com" . $eol;
    $header .= "Reply-To: hudderhubfresh@gmail.com" . $eol;


    $mail_sent = mail($to, $subject, $message, $header);
    if ($mail_sent == true) {
        $_SESSION["trader_mail_sent_message"] = "Please, Check your gmail to activate your account $gmail";
        header("location: login.php");
    }
}

function unique_product_name($connection, $product)
{

    $query = "select product_name from product where UPPER(product_name)='$product'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);

    $total_result = 0;
    while (($row = oci_fetch_array($stid)) != false) {
        ++$total_result;
    }
    oci_free_statement($stid);
    oci_close($connection);
    if ($total_result == 0) {
        return $product;
    } else {
        $_SESSION["product_error_message"] = "This product is already in sell.";
        header('location: traderdash3.php');
    }
}


function shopid_key($connection)
{
    $user_id = $_SESSION["user_id"];
    $query = "select shop_id from shop where user_id = $user_id";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);
    $count = 0;
    $shop_id = array();
    while (($row = oci_fetch_array($stid)) != false) {
        $shop_id[$count] = $row["SHOP_ID"];
        ++$count;
    }
    return $shop_id;
}



function shop_quantity($connection)
{
    $key = $_SESSION["user_id"];
    $query = "select USER_ID from shop where USER_ID = $key";
    $stid = oci_parse($connection, $query);
    if (oci_execute($stid)) {
        $total_result = 0;
        while (($row = oci_fetch_array($stid)) != false) {
            ++$total_result;
        }
    }

    if ($total_result >= 2) {
        $_SESSION["shop_number_exceeded"] = "Shop quantity exceeded.";
        header('location: traderdash7.php');
    } else {
        return true;
    }
}



function reset_password_validation($password)
{   
    if (strlen($password) < 5) {
        $_SESSION['password_error_message'] = "Password length must be 6 or greater.";
        header("location: traderdash6.php");
    } else {
        $pattern = '/[a-z\s]/i';
        $includes_alphabet = preg_match($pattern, $password);
        if ($includes_alphabet == 1) {
            $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            $includes_symbol = preg_match($pattern, $password);
            if ($includes_symbol == 1) {
                $includes_number = preg_match('~[0-9]~', $password);
                if ($includes_number == 1) {
                    return $password;
                } else {
                    $_SESSION['password_error_message'] = "Password must contain at least one numeric character.";
                    header("location: traderdash6.php");
                }
            } else {
                $_SESSION['password_error_message'] = "Password must contain at least one special character.";
                header("location: traderdash6.php");
            }
        } else {
            $_SESSION['password_error_message'] = "Password must contain alphabetic character.";
            header("location: traderdash6.php");
        }
    }
}


function get_PRICE($connection, $product_id)
{
    $query = "select PRICE from product where PRODUCT_ID=$product_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $maximum = $row["PRICE"];
            return $maximum;
        }
    }
}

function get_product_status($connection, $order_id)
{
    $query = "select ORDER_STATUS from user_order where ORDER_ID=$order_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $status = $row["ORDER_STATUS"];
            return $status;
        }
    }
}

function get_product_quantity($connection, $order_id)
{
    $query = "select PRODUCT_QUANTITY from order_product where ORDER_ID=$order_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $quantity = $row["PRODUCT_QUANTITY"];
            return $quantity;
        }
    }
}

function get_product_id($connection, $order_id)
{
    $query = "select PRODUCT_ID from order_product where ORDER_ID=$order_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $product_id = $row["PRODUCT_ID"];
            return $product_id;
        }
    }
}

function get_product_name($connection, $product_id)
{
    $query = "select PRODUCT_NAME from product where PRODUCT_ID= $product_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $product_n = $row["PRODUCT_NAME"];
            return $product_n;
        }
    }
}


function get_shop_id($connection, $product_id)
{
    $query = "select SHOP_ID from product where PRODUCT_ID= $product_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $shop_id = $row["SHOP_ID"];
            return $shop_id;
        }
    }
}

function get_customer_name($connection, $user_id)
{
    $query = "select FULL_NAME from HHF_USER where USER_ID= $user_id";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $user_name = $row["FULL_NAME"];
            return $user_name;
        }
    }
}

function get_day($connection, $order_id)
{
    $query = "select COLLECTION_SLOT_ID from USER_ORDER where ORDER_ID=$order_id ";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $slot_id = $row["COLLECTION_SLOT_ID"];

            $sql = "select SLOT_DAY from collection_slot where COLLECTION_SLOT_ID=$slot_id";
            $stid = oci_parse($connection, $sql);
            if (oci_execute($stid)) {
                while (($row = oci_fetch_assoc($stid)) != false) {
                    $day = $row["SLOT_DAY"];
                    return $day;
                }
            }
        }
    }
}
function get_slot_date($connection, $order_id)
{
    $query = "select COLLECTION_SLOT_DATE from USER_ORDER where ORDER_ID=$order_id ";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $slot_date = $row["COLLECTION_SLOT_DATE"];
                    return $slot_date;
        }
    }
}

function get_time($connection, $order_id)
{
    $query = "select COLLECTION_SLOT_ID from USER_ORDER where ORDER_ID=$order_id ";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $slot_id = $row["COLLECTION_SLOT_ID"];

            $sql = "select SLOT_TIME from collection_slot where COLLECTION_SLOT_ID=$slot_id";
            $stid = oci_parse($connection, $sql);
            if (oci_execute($stid)) {
                while (($row = oci_fetch_assoc($stid)) != false) {
                    $day = $row["SLOT_TIME"];
                    return $day;
                }
            }
        }
    }
}
?>