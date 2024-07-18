<?php
include('session.php');
include('connection.php');
include('functions.php');

$user_id = $_SESSION["user_id"];
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$date = date("d-m-Y");
$invoice_no = 1000;
$counter = $_SESSION["COUNTER"];
$to =$email ;
$subject = "YOUR ORDER HAS BEEN PLACED.";

$message = "
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />


    <head>
        
    

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css'
            integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>


        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap'
            rel='stylesheet'>
        <link
            href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300&family=Merriweather&family=Montserrat:wght@200;400&family=Poppins:wght@200&family=Sacramento&display=swap'
            rel='stylesheet'>
    </head>

<body>

    <!-- START OF EMAIL TEMP -->
    
    <div style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: ' Josefin Sans',
        sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>
    </div>

    <table border='0' cellpadding='0' cellspacing='0' width='100%'>

        <tr>
            <td bgcolor='#b8d6ce' align='center'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#b8d6ce' align='center' style='padding: 0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 800px;'>
                    <tr>
                </table>
            </td>
        </tr>
        <tr>
        
            <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 800px;'>
                
                    <tr>
                        <td bgcolor='#ffffff' align='left'>



                            <div class='title' style='margin-left:50px; font-size: 20px; font-family: Josefin Sans;'>
                                INVOICE
                            </div>
                            <hr style='background-color: #b8d6ce; width:95%;'>

                            <br>

                            <p class='start-text' style='font-family: Josefin Sans; font-size: 17px; margin-left: 50px'
                                ;>
                               <strong>Customer Name:</strong>  <span>". $name." </span> <br>
                               <strong>Email:</strong>  <span> ". $email."</span> <br>
                               <strong> Date Issued:</strong>  <span>". $date." </span> <br>
                               <strong>Invoice No:</strong>  <span> ". $invoice_no."</span>

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'>
                        
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                    <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>


                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th scope='col'>#</th>
                                                            <th scope='col'>Product Name</th>
                                                            <th scope='col'>Product Price</th>
                                                            <th scope='col'>Product Quantity</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                                        
                                                            
                                                            
                                                    $total = 0;
                                                    $count = 1;
                                                    $query = "select * from  ( select * from payment where user_id= $user_id order by payment_id desc ) where ROWNUM <= $counter";
                                                    $result = oci_parse($connection, $query);
                                                    if (oci_execute($result)) {

                                                        while (($row = oci_fetch_assoc($result)) != false) {
                                                            $amount = $row['AMOUNT'];
                                                            $date = $row['PAYMENT_DATE'];
                                                            $method = $row['PAYMENT_METHOD'];
                                                            $order_id = $row['ORDER_ID'];
                                                            $amount = $row['AMOUNT'];
                                                            $total = $total + $amount;

                                                            $sql = "select * from ORDER_PRODUCT where order_id=$order_id";
                                                            $stid = oci_parse($connection, $sql);
                                                            if (oci_execute($stid)) {
                                                                while (($row = oci_fetch_assoc($stid)) != false) {
                                                                    $quantity = $row['PRODUCT_QUANTITY'];
                                                                    $product_id = $row['PRODUCT_ID'];


                                                                    $queryyy = "select * from product where product_id = $product_id ";
                                                                    $results = oci_parse($connection, $queryyy);
                                                                    if (oci_execute($results)) {
                                                                        while (($row = oci_fetch_assoc($results)) != false) {
                                                                            $product_name = $row['PRODUCT_NAME'];
                                                                            $price = $row['PRICE'];
                                                                            $discount = get_discount_rate($connection, $product_id);

                                                                            $fprice = $price - (($price * $discount) / 100);
                                                                        }
                                                                    }


                                                                    $message.=" <tr>
                                                                    <th scope='row'>".$count."</th>
                                                                    <td align='center'>". $product_name."</td>
                                                                    <td align='center'> ".$fprice."</td>
                                                                    <td align='center'>". $quantity."</td>
                                                                    </tr>
                                                                    ";
                                                                    $count++;
                                                                }
                                                            }
                                                        }
                                                    }

                                                            $message.="<tr>

                                                <br>
                                                <br>

                                                <td bgcolor='#ffffff' align='center'
                                                    style='padding: 0px 10px 0px 10px;'>
                                                    <table border='0' cellpadding='0' cellspacing='0' width='100%'
                                                        style='max-width: 800px;'>
                                                        <tr>
                                                            <td bgcolor='#ffffff' align='left'>
                                                                <br>
                                                                <p class='start-text'
                                                                    style='font-family: Josefin Sans; font-size: 17px; margin-left: 10px'
                                                                    ;>
                                                                    Total: £<span>".$total."</span> <br>
                                                                    Payment Method: <span>". $method."</span> <br>
                                                                    Payment Date: <span>". $date." </span> <br>

                                                                </p>
                                                            </td>
                                                        </tr>



                                                    </table>



                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td bgcolor='#ffffff' align='center' style='padding-bottom: 30px; font-size: 18px;'>

                                        Thank you for shopping!




                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                
             </table>
            


</body>
</html>

";

$eol = PHP_EOL;

$header = "MIME-Version: 1.0" . $eol;
$header .= "Content-type:text/html;charset=UTF-8" .$eol;
// Basic headers
$header .= "From: hudderhubfresh@gmail.com".$eol;
$header .= "Reply-To: hudderhubfresh@gmail.com".$eol;
mail($to,$subject,$message,$header);

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />


    <head>

        <script src='https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js'></script>
        <script src="script.js"></script>

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>


        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300&family=Merriweather&family=Montserrat:wght@200;400&family=Poppins:wght@200&family=Sacramento&display=swap' rel='stylesheet'>
    </head>

<body>
    <div id="invoice">
        <div style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: ' Josefin Sans', sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>
        </div>

        <table border='0' cellpadding='0' cellspacing='0' width='100%'>

            <tr>
                <td bgcolor='#b8d6ce' align='center'>
                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                        <tr>
                            <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor='#b8d6ce' align='center' style='padding: 0px 10px 0px 10px;'>
                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 800px;'>
                        <tr>
                            <td bgcolor='#ffffff' align='right' valign='top' style='padding: 40px 60px 40px 40px;  border-radius: 4px 4px 0px 0px;  color: #111111; font-family: ' Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                                <<a class="navbar-logo" href="index.php">
                    <img src="images/finallogo.png" style="margin-left:30px; max-width:40px;" alt="HudderHub Logo">
                    <a style="font-family: Josefin Sans; font-weight: 600; color: black; text-decoration: none;" href="index.php">&nbsp;HudderHub Fresh</a>

                </a>


                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>

                <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>

                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 800px;'>

                        <tr>
                            <td bgcolor='#ffffff' align='left'>



                                <div class="title" style="margin-left:50px; font-size: 20px; font-family: Josefin Sans;">
                                    INVOICE
                                </div>
                                <hr style="background-color: #b8d6ce; width:95%;">

                                <br>

                                <p class='start-text' style='font-family: Josefin Sans; font-size: 17px; margin-left: 50px' ;>
                                    <strong>Customer Name:</strong> <span><?php echo $name; ?> </span> <br>
                                    <strong>Email:</strong> <span> <?php echo $email; ?></span> <br>
                                    <strong> Date Issued:</strong> <span><?php echo $date; ?> </span> <br>
                                    <strong>Invoice No:</strong> <span> <?php echo $invoice_no;
                                                                        ++$invoice_no; ?></span>

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor='#ffffff' align='left'>

                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                        <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                            <table border='0' cellspacing='0' cellpadding='0'>
                                                <tr>


                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>

                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Product Price</th>
                                                                <th scope="col">Product Quantity</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            $total = 0;
                                                            $count = 1;
                                                            $query = "select * from  ( select * from payment where user_id= $user_id order by payment_id desc ) where ROWNUM <= $counter";
                                                            $result = oci_parse($connection, $query);
                                                            if (oci_execute($result)) {

                                                                while (($row = oci_fetch_assoc($result)) != false) {
                                                                    $amount = $row['AMOUNT'];
                                                                    $date = $row['PAYMENT_DATE'];
                                                                    $method = $row['PAYMENT_METHOD'];
                                                                    $order_id = $row['ORDER_ID'];
                                                                    $amount = $row['AMOUNT'];
                                                                    $total = $total + $amount;

                                                                    $sql = "select * from ORDER_PRODUCT where order_id=$order_id";
                                                                    $stid = oci_parse($connection, $sql);
                                                                    if (oci_execute($stid)) {
                                                                        while (($row = oci_fetch_assoc($stid)) != false) {
                                                                            $quantity = $row['PRODUCT_QUANTITY'];
                                                                            $product_id = $row['PRODUCT_ID'];


                                                                            $queryyy = "select * from product where product_id = $product_id ";
                                                                            $results = oci_parse($connection, $queryyy);
                                                                            if (oci_execute($results)) {
                                                                                while (($row = oci_fetch_assoc($results)) != false) {
                                                                                    $product_name = $row['PRODUCT_NAME'];
                                                                                    $price = $row['PRICE'];
                                                                                    $discount = get_discount_rate($connection, $product_id);

                                                                                    $fprice = $price - (($price * $discount) / 100);
                                                                                }
                                                                            }



                                                            ?>
                                                                            <tr>
                                                                                <th scope="row"><?php echo $count; ?></th>
                                                                                <td><?php echo $product_name; ?></td>
                                                                                <td><?php echo $fprice; ?></td>
                                                                                <td><?php echo $quantity; ?></td>
                                                                            </tr>
                                                            <?php
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?><tr>

                                                                <br>
                                                                <br>

                                                                <td bgcolor='#ffffff' align='center' style='padding: 0px 10px 0px 10px;'>
                                                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 800px;'>
                                                                        <tr>
                                                                            <td bgcolor='#ffffff' align='left'>
                                                                                <br>
                                                                                <p class='start-text' style='font-family: Josefin Sans; font-size: 17px; margin-left: 10px' ;>
                                                                                    Total: £<span><?php echo $total; ?></span> <br>
                                                                                    Payment Method: <span><?php echo $method; ?> </span> <br>
                                                                                    Payment Date: <span><?php echo $date; ?> </span> <br>
                                                                                </p>
                                                                            </td>
                                                                        </tr>



                                                                    </table>



                                                                </td>
                                                            </tr>
                                                    </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td bgcolor='#ffffff' align='center' style="padding-bottom: 30px; font-size: 18px;">

                                            Thank you for shopping!




                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>

                    </table>

            </tr>
        </table>
    </div>





    <br><br>
    <div class="download text-center">
        <button class="button-33" role="button" onclick="generatePDF()"> Download as PDF</button>
    </div>
    <style>
        .button-33 {
            background-color: #c2fbd7;
            border-radius: 100px;
            box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset, rgba(44, 187, 99, .15) 0 1px 2px, rgba(44, 187, 99, .15) 0 2px 4px, rgba(44, 187, 99, .15) 0 4px 8px, rgba(44, 187, 99, .15) 0 8px 16px, rgba(44, 187, 99, .15) 0 16px 32px;
            color: green;
            cursor: pointer;
            display: inline-block;
            font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
            padding: 7px 20px;
            text-align: center;
            text-decoration: none;
            transition: all 250ms;
            border: 0;
            font-size: 16px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .button-33:hover {
            box-shadow: rgba(44, 187, 99, .35) 0 -25px 18px -14px inset, rgba(44, 187, 99, .25) 0 1px 2px, rgba(44, 187, 99, .25) 0 2px 4px, rgba(44, 187, 99, .25) 0 4px 8px, rgba(44, 187, 99, .25) 0 8px 16px, rgba(44, 187, 99, .25) 0 16px 32px;
            transform: scale(1.05) rotate(-1deg);
        }
    </style>
    <br><br>
    </div>
</body>

</html>