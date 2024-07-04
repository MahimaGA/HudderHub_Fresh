<?php
include('trader_header.php')
?>
<!doctype html>
<html lang="en">
</body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="trader-profile">View Order</h2>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Time</th>
                        <th scope="col">Recieving Date</th>
                        <th scope="col">Recieving Day</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shop_id = array();
                    $shop_id = shopid_key($connection);

                    $counter = 1;
                    $user_id = $_SESSION["user_id"];
                    $query = "select * from payment";
                    $result = oci_parse($connection, $query);
                    if (oci_execute($result)) {
                        while (($row = oci_fetch_assoc($result)) != false) {
                            $order_id = $row["ORDER_ID"];
                            $amount = $row["AMOUNT"];
                            $date = $row["PAYMENT_DATE"];
                            $invoice = $row["ORDER_ID"];
                            $customer = $row["USER_ID"];



                            $product_id = get_product_id($connection, $order_id);
                            if (!empty($product_id)) {
                                $shop = get_shop_id($connection, $product_id);
                                if (!empty($shop)) {
                                    if (!in_array($shop, $shop_id)) {
                                        continue;
                                    }
                                }
                            }
                            $day = get_day($connection, $order_id);
                            $status = get_product_status($connection, $order_id);
                            $slot_date = get_slot_date($connection, $order_id);
                            $quantity = get_product_quantity($connection, $order_id);
                            if (empty($quantity)) {
                                continue;
                            }
                            $product_name = get_product_name($connection, $product_id);
                            $customer_name = get_customer_name($connection, $customer);
                            $time = get_time($connection, $order_id);
                            $price = get_PRICE($connection, $product_id);

                    ?>
                            <tr>
                                <th scope="row"><?php echo $counter; ?></th>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $product_name; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $time; ?></td>
                                <td><?php echo $slot_date; ?></td>
                                <td><?php echo $day; ?></td>
                                
                                <td><?php
                                    if (isset($status)) {
                                        if ($status == 'PROCESSING') {
                                            $task = "delivered";
                                    ?>
                                            <a href="order_status.php?id=<?php echo $order_id; ?>&task=<?php echo $task; ?>">
                                                <button class="btn btn-default" style="background-color:#FF6666; margin-left: 15px">PROCESSING</button>
                                            </a>
                                        <?php
                                        } else {
                                            $task = "processing";
                                        ?>
                                            <a href="order_status.php?id=<?php echo $order_id; ?>&task=<?php echo $task; ?>">
                                                <button class="btn btn-default" style="background-color:#a8e4a0; margin-left: 15px">DELIVERED</button>
                                            </a>
                                    <?php

                                        }
                                    }
                                    ?>
                                </td>

                            </tr>
                    <?php
                            ++$counter;
                        }
                    }
                    ?>



                </tbody>
            </table>

        </div>
    </div>
</div>

</div>
</div>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    $(".image-box").click(function(event) {
        var previewImg = $(this).children("img");

        $(this)
            .siblings()
            .children("input")
            .trigger("click");

        $(this)
            .siblings()
            .children("input")
            .change(function() {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var urll = e.target.result;
                    $(previewImg).attr("src", urll);
                    previewImg.parent().css("background", "transparent");
                    previewImg.show();
                    previewImg.siblings("p").hide();
                };
                reader.readAsDataURL(this.files[0]);
            });
    });
</script>
</body>

</html>