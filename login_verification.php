<?php
include('session.php');
include('connection.php');



function login_verification($connection, $username, $password)
{
    $hashed_password = md5($password);
    $query = "SELECT USER_ID, FULL_NAME, EMAIL, USER_PASSWORD, USER_ROLE, CONTACT_NO, CREATED_DATE, UPDATED_DATE, DATE_OF_BIRTH, USER_PHOTO, STATUS, USERNAME FROM HHF_USER WHERE USERNAME = :username AND USER_PASSWORD = :password";
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


if (isset($_POST['login'])) {
    if (!empty($_POST['username'])  && !empty($_POST['password'])) {
        $username = strtolower($_POST['username']);
        $user_password = $_POST['password'];
        login_verification($connection, $username, $user_password);
    } else {
        $_SESSION["feild_empty_message"] = "Provide your username and password.";
        header("location: login.php");
        exit;
    }
}
?>