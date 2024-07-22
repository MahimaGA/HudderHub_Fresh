<?php
include('session.php');
include('connection.php');
include('functions.php');
$_SESSION['empty_error_message'] = "";
if (isset($_POST["traderl"])) {
    if (
        !empty($_POST["fullname"])
        && !empty($_POST["email"])
        && !empty($_POST["password"])
        && !empty($_POST["contact"])
        && !empty($_POST["birthday"])
        && !empty($_POST["sell-textbox"])
    ) {
        $fullname = strtoupper($_POST["fullname"]);
        $email = $_POST["email"];
        $password = $_POST["password"];
        $contact = $_POST["contact"];
        $birthday = $_POST["birthday"];
        $message_to_admin = strtoupper($_POST["sell-textbox"]);
        $user_role = "T";
        $active_status = "0";
        $created_date = date('Y-m-d');
        $gmail = email_validation($email, $user_role);

        if (!empty($gmail)) {
            $fpassword = password_validation($password);
            $final_password = md5($password);
            if ($fpassword == true) {
                $username = unique_username($connection, $gmail, $user_role);
                if (!empty($username)) {
                    $_SESSION['hhf_user_fullname'] = $fullname;
                    $_SESSION['hhf_user_gmail'] = $gmail;
                    $_SESSION['hhf_user_password'] = $final_password;
                    $_SESSION['hhf_user_contact'] = $contact;
                    $_SESSION['hhf_user_birthday'] = $birthday;
                    $_SESSION['hhf_user_role'] = $user_role;
                    $_SESSION['hhf_active_status'] = $active_status;
                    $_SESSION['hhf_username'] = $username;
                    $_SESSION['hhf_message_toadmin'] = $message_to_admin;
                    $_SESSION['hhf_created_date'] = $created_date;

                    header('location: traderregister2.php');
                }
            } else {
                header('location:traderregister.php');
            }
        }
    } else {
        $_SESSION['empty_error_message'] = "All fields are required.";
        header("location:traderregister.php");
    }
}

if (isset($_POST['trader2'])) {
    if (
        !empty($_POST['shop_name'])
        && !empty($_POST['location'])
        && !empty($_POST['pan'])
        && !empty($_POST['sell-point'])
    ) {
        $shop_name = strtoupper($_POST['shop_name']);
        $_SESSION['hhf_location'] = strtoupper($_POST['location']);
        $pan = $_POST['pan'];
        $_SESSION['hhf_sellingPoint']  = $_POST['sell-point'];
        $_SESSION['status'] = '0';
        $redirect = "traderregister2.php";
        $_SESSION['hhf_shopname'] = unique_shopname($connection, $shop_name, $redirect);
        if (!empty($_SESSION['hhf_shopname'])) {
            $panNumber = intval($pan);
            if (is_int($panNumber)) {
                $_SESSION['registration_no'] = unique_pan($connection, $panNumber, $redirect);
                if (!empty($_SESSION['registration_no'])) {

                    $token = bin2hex(random_bytes(10));

                    $query = "INSERT INTO HHF_USER(full_name, username, user_password, email, contact_no, user_role, date_of_birth, status, verification_code, created_date) 
                                    VALUES (:name, :username, :password, :email, :contact, :role, TO_DATE(:bdate, 'YYYY-MM-DD'), :status, :token, TO_DATE(:created_date, 'YYYY-MM-DD'))";
                    $result = oci_parse($connection, $query);

                    oci_bind_by_name($result, ':name', $_SESSION['hhf_user_fullname']);
                    oci_bind_by_name($result, ':username', $_SESSION['hhf_username']);
                    oci_bind_by_name($result, ':password', $_SESSION['hhf_user_password']);
                    oci_bind_by_name($result, ':email', $_SESSION['hhf_user_gmail']);
                    oci_bind_by_name($result, ':contact', $_SESSION['hhf_user_contact']);
                    oci_bind_by_name($result, ':role', $_SESSION['hhf_user_role']);
                    oci_bind_by_name($result, ':bdate', $_SESSION['hhf_user_birthday']);
                    oci_bind_by_name($result, ':status', $_SESSION['hhf_active_status']);
                    oci_bind_by_name($result, ':token', $token);
                    oci_bind_by_name($result, ':created_date', $_SESSION['hhf_created_date']);
                    oci_execute($result);

                    $foreign_key = foreign_key($connection, $_SESSION['hhf_username']);


                    $sql = "insert into shop (shop_name,shop_location,registration_no,status,user_id)
                                  values(:shopname,:location,:registration,:status,:foreign)";
                    $results = oci_parse($connection, $sql);

                    oci_bind_by_name($results, ':shopname', $_SESSION['hhf_shopname']);
                    oci_bind_by_name($results, ':location', $_SESSION['hhf_location']);
                    oci_bind_by_name($results, ':registration', $_SESSION['registration_no']);
                    oci_bind_by_name($results, ':status', $_SESSION['status']);
                    oci_bind_by_name($results, ':foreign', $foreign_key);
                    if (oci_execute($results)) {
                        trader_gmail_verification($_SESSION['hhf_user_fullname'], $_SESSION['hhf_user_gmail'], $token, $foreign_key);
                    }
                }
            } else {
                $_SESSION['pan_error_message'] = "Invalid registration number.";
                header("location: traderregister2.php");
            }
        }
    } else {
        $_SESSION['empty_error_message'] = "All fields are required.";
        header("location: traderregister2.php");
    }
}
?>