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
    $query = "select username from HHF_USER where username='$temp'";
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



function reset_password_validation($password)
{ 
    if (strlen($password) < 5) {
        $_SESSION['password_error_message'] = "Password length must be 6 or greater.";
        header("location: admindash5.php");
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
                    header("location: admindash5.php.php");
                }
            } else {
                $_SESSION['password_error_message'] = "Password must contain at least one special character.";
                header("location: admindash5.php");
            }
        } else {
            $_SESSION['password_error_message'] = "Password must contain alphabetic character.";
            header("location: admindash5.phpp");
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
    $query = "select PRODUCT_QUANTITY from ORDER_PRODUCT where ORDER_ID=$order_id";
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

function get_shop_name($connection, $shop_id)
{
    $query = "select shop_name from SHOP where shop_id= $shop_id";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
            $shop_name = $row["SHOP_NAME"];
            return $shop_name;
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