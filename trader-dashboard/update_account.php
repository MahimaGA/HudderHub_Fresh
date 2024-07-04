<?php
session_start();
include('session.php');
include('connection.php');

$name = '';
$contact = '';
$birthdate = '';

if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM HHF_USER WHERE USER_ID = $user_id";
    $result = oci_parse($connection, $query);
    
    if (oci_execute($result)) {
        $row = oci_fetch_assoc($result);
        if ($row) {
            $name = $row["FULL_NAME"];
            $contact = $row["CONTACT_NO"];
            $birthdate = date('m-d-Y', strtotime($row["DATE_OF_BIRTH"]));
        } else {
            $_SESSION['update_message'] = "No data found for user ID: $user_id"; 
            header("location: traderdash5.php");
            exit();
        }
    } else {
        $e = oci_error($result);
        $_SESSION['update_message'] = "Database query execution failed: " . htmlentities($e['message']);
        header("location: traderdash5.php");
        exit();
    }
} else {
    $_SESSION['update_message'] = "User ID not found in session";
    header("location: traderdash5.php");
    exit();
}

if (isset($_POST["update_profile"])) {
    if (!empty($_POST["name"]) && !empty($_POST["number"]) && !empty($_POST["date"])) {
        $name = strtoupper($_POST["name"]);
        $contact = $_POST["number"];
        $birth_date = $_POST["date"];
        $birth_date_formatted = date('m-d-Y', strtotime($birth_date));
        if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $query = "UPDATE HHF_USER SET FULL_NAME = :name, CONTACT_NO = :contact, DATE_OF_BIRTH = TO_DATE(:birth_date, 'MM-DD-YYYY') WHERE USER_ID = :user_id";
            $result = oci_parse($connection, $query);
            oci_bind_by_name($result, ":name", $name);
            oci_bind_by_name($result, ":contact", $contact);
            oci_bind_by_name($result, ":birth_date", $birth_date_formatted);
            oci_bind_by_name($result, ":user_id", $user_id);
            $execute_success = oci_execute($result);

            if ($execute_success) {
                $_SESSION['update_message'] = "Profile updated successfully.";
                $_SESSION["name"] = $name;
                $_SESSION["contact"] = $contact;
                $_SESSION["birthdate"] = $birth_date;
                header("location: traderdash5.php");
                exit();
            } else {
                $e = oci_error($result);
                $_SESSION['update_message'] = "Query execution error: " . htmlentities($e['message']);
                header("location: traderdash5.php");
                exit();
            }
        } else {
            $_SESSION['update_message'] = "User ID not found.";
            header("location: traderdash5.php");
            exit();
        }
    } else {
        $_SESSION['update_message'] = "Please fill in all fields.";
        header("location: traderdash5.php");
        exit();
    }
}
?>
