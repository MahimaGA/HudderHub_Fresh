<?php
include('session.php');
include('connection.php');

if (!empty($_SESSION["username"])) {
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        if (!empty($id)) {
            $page = $_GET["page"];
            $user_id = $_SESSION["user_id"];
            $querys = "select * from WISHLIST where product_id=$id and user_id = $user_id";
            $counter = 0;
            $stid = oci_parse($connection, $querys);
            if (oci_execute($stid)) {
                $counter = 0;
                while (($row = oci_fetch_assoc($stid)) != false) {
                    $unit = $row["PRODUCT_QUANTITY"];
                    ++$counter;
                }
                if ($counter == 0) {

                    $query = "insert into WISHLIST (product_id,user_id) 
                    values (:product_id,:user_id)";
                    $result = oci_parse($connection, $query);

                    oci_bind_by_name($result, ':product_id', $id);
                    oci_bind_by_name($result, ':user_id', $user_id);


                    if (oci_execute($result)) {
                        header('location: ' . $page);
                    }
                } else {
                    header('location: ' . $page);
                }
            }
        }
    }
} else {
    header('location: login.php');
}
?>