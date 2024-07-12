<?php
include('connection.php');
include('session.php');
include('functions.php');
$selectedDay = $_GET["d"];
$selectedDate = $_GET["date"];
$time = $_GET["t"];
$order_date = date("d-m-Y");
$COUNTER = 0;
$user_id = $_SESSION["user_id"];

$query = "SELECT * FROM cart WHERE user_id = $user_id AND purchase = 0";
$result = oci_parse($connection, $query);

if (oci_execute($result)) {
    while (($row = oci_fetch_assoc($result)) != false) {
        $cart_id = $row["CART_PRODUCT_ID"];
        $product_id = $row["PRODUCT_ID"];
        $quantity = $row["PRODUCT_QUANTITY"];

        $discount = get_discount_rate($connection, $product_id);

        $Query = "SELECT * FROM product WHERE PRODUCT_ID = $product_id";
        $stid = oci_parse($connection, $Query);
        if (oci_execute($stid)) {
            while (($row = oci_fetch_assoc($stid)) != false) {
                $price = $row["PRICE"];
                $total = ($price - (($price * $discount) / 100)) * $quantity;

                $update_stock_query = "UPDATE product SET STOCK = STOCK - $quantity WHERE PRODUCT_ID = $product_id";
                $update_stock_statement = oci_parse($connection, $update_stock_query);
                oci_execute($update_stock_statement);

                $q = "SELECT * FROM COLLECTION_SLOT WHERE slot_day = '$selectedDay' AND slot_time = '$time'";
                $r = oci_parse($connection, $q);
                if (oci_execute($r)) {
                    while (($row = oci_fetch_assoc($r))) {
                        $collectionslot_id = $row["COLLECTION_SLOT_ID"];
                    }
                    $sql = "INSERT INTO USER_ORDER(order_date, order_status, cart_PRODUCT_id, collection_slot_id, collection_slot_date)
                            VALUES(to_date(:order_date,'DD/MM/YYYY'), :status, :cart_id, :slot_id, to_date(:collection_date,'YYYY-MM-DD'))"; // Assuming the date format is 'YYYY-MM-DD'
                    $insert = oci_parse($connection, $sql);
                    $status = "PROCESSING";

                    oci_bind_by_name($insert, ':order_date', $order_date);
                    oci_bind_by_name($insert, ':status', $status);
                    oci_bind_by_name($insert, ':cart_id', $cart_id);
                    oci_bind_by_name($insert, ':slot_id', $collectionslot_id);
                    oci_bind_by_name($insert, ':collection_date', $selectedDate);

                    if (oci_execute($insert)) {
                        $orderid = "SELECT * FROM USER_ORDER WHERE cart_PRODUCT_id = $cart_id";
                        $resul = oci_parse($connection, $orderid);
                        if (oci_execute($resul)) {
                            while (($row = oci_fetch_assoc($resul))) {
                                $order_id = $row["ORDER_ID"];
                            }

                            $orderdetail = "INSERT INTO ORDER_PRODUCT(product_quantity, order_id, product_id)
                                            VALUES(:quantity, :order_id, :product_id)";
                            $insert_orderdetails = oci_parse($connection, $orderdetail);

                            oci_bind_by_name($insert_orderdetails, ':quantity', $quantity);
                            oci_bind_by_name($insert_orderdetails, ':order_id', $order_id);
                            oci_bind_by_name($insert_orderdetails, ':product_id', $product_id);

                            if (oci_execute($insert_orderdetails)) {
                                $payment = "INSERT INTO PAYMENT (amount, payment_date, payment_method, order_id, user_id)
                                            VALUES(:amount, to_date(:pay_date,'DD/MM/YYYY'), :method, :order_id, :user_id)";
                                $insert = oci_parse($connection, $payment);
                                $method = "PAYPAL";

                                oci_bind_by_name($insert, ':amount', $total);
                                oci_bind_by_name($insert, ':pay_date', $order_date);
                                oci_bind_by_name($insert, ':method', $method);
                                oci_bind_by_name($insert, ':order_id', $order_id);
                                oci_bind_by_name($insert, ':user_id', $user_id);

                                oci_execute($insert);

                                $update = "UPDATE cart SET purchase = 1 WHERE cart_product_ID = $cart_id";
                                $parse = oci_parse($connection, $update);
                                oci_execute($parse);

                                ++$COUNTER;
                                $_SESSION["COUNTER"] = $COUNTER;
                            } else {
                                $error = oci_error($insert_orderdetails);
                                echo "Error: " . $error['message'];
                            }

                            oci_free_statement($insert_orderdetails);
                        }
                    }
                }
            }
        }
    }
    header('location:invoice.php');
}
?>
