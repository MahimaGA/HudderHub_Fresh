<?php
include('connection.php');
include('session.php');
if (isset($_POST['checkout'])) {
    $day = $_POST['day'];
    $time = $_POST['time'];
    $total = $_POST['total'];
    $timestamp = strtotime($day);
    $selectedDay = date('D', $timestamp);
    $selectedDate = date('Y-m-d', $timestamp); 
    $query = "SELECT cs.COLLECTION_SLOT_ID, COUNT(uo.ORDER_ID) AS order_count
              FROM COLLECTION_SLOT cs
              LEFT JOIN USER_ORDER uo ON cs.COLLECTION_SLOT_ID = uo.COLLECTION_SLOT_ID
              WHERE cs.slot_day = :selectedDay AND cs.slot_time = :time
              AND TO_CHAR(uo.COLLECTION_SLOT_DATE, 'MM/DD/YYYY') = :selectedDate
              GROUP BY cs.COLLECTION_SLOT_ID";
    $statement = oci_parse($connection, $query);
    oci_bind_by_name($statement, ':selectedDay', $selectedDay);
    oci_bind_by_name($statement, ':time', $time);
    oci_bind_by_name($statement, ':selectedDate', $selectedDate);

    if (oci_execute($statement)) {
        $row = oci_fetch_assoc($statement);
        if ($row) {
            $collectionslot_id = $row["COLLECTION_SLOT_ID"];
            $order_count = isset($row['ORDER_COUNT']) ? (int) $row['ORDER_COUNT'] : 0;
            $max_orders_per_slot = 20; 

            if ($order_count >= $max_orders_per_slot) {
                $_SESSION['checkout_error'] = "Sorry, the selected collection slot is full. Please choose another slot.";
                header("Location: checkout.php");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HudderHub Fresh</title>
</head>

<body>
    <?php
    ?>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="POST" id="buyCredits" name="buyCredits">

        <input type="hidden" name="business" value="sb-2dxo030760455@business.example.com" />

        <input type="hidden" name="cmd" value="_xclick" />

        <input type="hidden" name="amount" value="<?php echo $total ?> " />

        <input type="hidden" name="currency_code" value="USD" />

        <input type="hidden" name="return" value="http://localhost/hudderhub_fresh/after_payment.php?d=<?php echo urlencode($selectedDay); ?>&date=<?php echo urlencode($selectedDate); ?>&t=<?php echo urlencode($time); ?>&ta=<?php echo urlencode($total); ?>" />

    </form>

    <script>
        document.getElementById("buyCredits").submit();
    </script>
</body>
<!-- Email ID:
hubberhubfresh@gmail.com
Generated Password:
Test@123 -->

</html>
