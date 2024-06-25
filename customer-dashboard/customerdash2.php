<?php
include('cust_dash_header.php');

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$name = $_SESSION["name"];
$gmail = $_SESSION["email"];
$contact = $_SESSION["contact"];
$birthdate = $_SESSION["birthdate"];
$image = $_SESSION["user_image"];

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HudderHub Fresh</title>
    <link rel="stylesheet" href="style8.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>
</head>
<body>


    <div class="container">

        <div class="row">

            <div class="col-md-12">



                <h2 class="trader-profile"> Orders</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Quantity</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Delivery Date</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $counter = 1;
                        $query = "select * from payment where USER_ID = $user_id ";
                        $result = oci_parse($connection, $query);
                        if (oci_execute($result)) {
                            while (($row = oci_fetch_assoc($result)) != false) {
                                $order_id = $row["ORDER_ID"];
                                $amount = $row["AMOUNT"];
                                $date = $row["PAYMENT_DATE"];
                                $invoice = $row["ORDER_ID"];

                                $status = get_product_status($connection, $order_id);
                                $quantity = get_product_quantity($connection, $order_id);
                                $product_id = get_product_id($connection, $order_id);
                                $slot_date = get_slot_date($connection, $order_id);
                                $product_name = get_product_name($connection, $product_id);
                                if (empty($product_name)) {
                                    continue;
                                }
                                $shop_name = get_shop_name($connection, $product_id);

                        ?>
                                <tr>
                                    <th scope="row"><?php echo $counter; ?></th>
                                    <td><?php echo $product_name; ?></td>
                                    <td><?php echo $amount; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $shop_name; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $slot_date; ?></td>
                                    <td><?php echo $invoice; ?></td>
                                    <td><?php echo $status; ?></td>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
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