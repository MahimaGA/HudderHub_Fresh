<?php

include("session.php");
include("connection.php");
require("functions.php");
$_SESSION['empty_error_message'] = "";

if (isset($_POST["user_registration"])) {
    if (!empty($_POST["fullname"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["birthday"])) {

        $fullname = strtoupper($_POST["fullname"]);
        $email = strtolower($_POST["email"]);
        $password = $_POST["password"];
        $contact = $_POST["contact"];
        $birthday = $_POST["birthday"];
        $user_role = "C";
        $active_status = "0";
        $created_date = date('Y-m-d');

        $gmail = email_validation($email, $user_role);

        echo "Email Validation Result: ";
        var_dump($gmail);

        if (!empty($gmail)) {
            $fpassword = password_validation($password);
            $final_password = md5($password);
            if ($fpassword == true) {
                $username = unique_username($connection, $gmail, $user_role);
                echo "Username: $username<br>";

                if (!empty($username)) {
                    $token = bin2hex(random_bytes(16));

                    $query = "INSERT INTO HHF_USER(full_name, username, user_password, email, contact_no, user_role, date_of_birth, status, verification_code, created_date) 
                    VALUES (:name, :username, :password, :email, :contact, :role, TO_DATE(:bdate, 'YYYY-MM-DD'), :status, :token, TO_DATE(:created_date, 'YYYY-MM-DD'))";
                    $result = oci_parse($connection, $query);
                    echo "SQL Query: $query<br>";

                    oci_bind_by_name($result, ':name', $fullname);
                    oci_bind_by_name($result, ':username', $username);
                    oci_bind_by_name($result, ':password', $final_password);
                    oci_bind_by_name($result, ':email', $gmail);
                    oci_bind_by_name($result, ':contact', $contact);
                    oci_bind_by_name($result, ':role', $user_role);
                    oci_bind_by_name($result, ':bdate', $birthday);
                    oci_bind_by_name($result, ':status', $active_status);
                    oci_bind_by_name($result, ':token', $token);
                    oci_bind_by_name($result, ':created_date', $created_date);

                    $query_execution = oci_execute($result);

                    if ($query_execution) {
                        gmail_verification($fullname, $gmail, $token);
                    } else {
                        $e = oci_error($result);
                        echo "SQL Error: " . $e['message'];
                    }
                    echo "Query Execution Result: ";
                    var_dump($query_execution);
                } else {
                    echo "Error: Unable to generate unique username.";
                }
            } else {
                echo "Error: Password is not valid.";
            }
        } else {
            echo "Error: Email is not valid.";
        }
    } else {
        $_SESSION['empty_error_message'] = "* All fields must be filled. *";
        header("location:newregister.php");
    }
}
?>