<!doctype html>
<html lang="en">
<?php
include('customer_header.php');
include('functions.php');
$p_quantity = 0;
$user_id = $_SESSION["user_id"];
$query = "select * from cart where user_id= $user_id and purchase=0";
$result = oci_parse($connection, $query);
if (oci_execute($result)) {
  while (($row = oci_fetch_assoc($result)) != false) {
    $quantity = $row["PRODUCT_QUANTITY"];
    $p_quantity = $p_quantity + $quantity;
  }
}
if ($p_quantity > 20) {
  $_SESSION["quantity_message"] = "Total product quantity can not be more than 20, Please remove some products or thier quantity to proceed forward.";
?><script>
    window.location.href = "shopcart.php";
    die;
  </script>
<?php
}

?>

<br>
<br>
<br>

<div class="shopping-title"> Order Details </div>

<br>
<div class="container">
  <div class="row">
    <div class="col-md-12">

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

          $counter = 1;
          $total = 0;
          $user_id = $_SESSION["user_id"];
          $query = "select * from cart where user_id= $user_id and purchase=0";
          $result = oci_parse($connection, $query);
          if (oci_execute($result)) {
            while (($row = oci_fetch_assoc($result)) != false) {
              $product_id = $row["PRODUCT_ID"];
              $quantity = $row["PRODUCT_QUANTITY"];
              $discount = get_discount_rate($connection, $product_id);

              $query = "select * from product where PRODUCT_ID = $product_id";
              $stid = oci_parse($connection, $query);
              if (oci_execute($stid)) {
                while (($row = oci_fetch_assoc($stid)) != false) {
                  $name = $row["PRODUCT_NAME"];
                  $image = $row["PRODUCT_IMAGE"];
                  $price = $row["PRICE"];
                  $total = $total + (($price - ($price * $discount) / 100) * $quantity);




          ?>
                  <tr>
                    <th scope="row"><?php echo $counter; ?></th>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $price - (($price * $discount) / 100); ?></td>
                    <td><?php echo $quantity; ?></td>
                  </tr>
          <?php
                  ++$counter;
                }
              }
            }
          }
          ?>



        </tbody>
      </table>

    </div>
  </div>
</div>


<br>


<div class="price-title"> Total Price: £ <span><?php echo $total; ?></span> </div>
</div>
</div>
</div>

<br>

<br>

<br>
<div class="error_message">
  <?php 
  
    if(isset($_SESSION['checkout_error']))
    {
      echo $_SESSION['checkout_error'];
      unset($_SESSION['checkout_error']);
    }
  ?>
</div>



<div class="container">
  <div class="row">
    <div class="col-md-7">
      <form action="checkout_process.php" method="post">
        <div class="slot-title">Choose a collection slot:</div>
        <br>
        <p class="collecttxt"> Collection Day:
          <input type="calendar" id="datepicker" name="day" style="width:50%; height: 40px;" />
        </p>
        <label for="time" class="timetxt"> Collection Time: </label>
        <select name="time" id="time" style="background-color: white; width:50%; height: 60px;">
          <option value="10-13"> 10-13</option>
          <option value="13-16"> 13-16</option>
          <option value="16-19"> 16-19</option>
        </select>
        <input type="hidden" name="total" value="<?php echo $total; ?>">
    </div>
    <div class="offset-1 col-md-4" style="height:400px; background-color: white;">
      <div class="slot-title"> Payment: </div>
      <br>
      <img src="images/paypal.png" alt="" srcset="" style="max-width: 150px;">
      <br>
      <br>
      <button class="btn btn-success" type="submit" name="checkout"> Checkout with PayPal </button>
      <br>
    </div>
    </form>
  </div>
</div>

<p class="collecttxt">Selected Day: <span id="selectedDay"></span></p>
<p class="collecttxt">Selected Date: <span id="selectedDate"></span></p>

<script type="text/javascript">
  $(function() {
    $("#datepicker").datepicker({
      minDate: 1,
      beforeShowDay: function(date) {
        var day = date.getDay();
        return [(day != 0 && day != 2 && day != 6 && day != 1)];
      },
      onSelect: function(dateText, inst) {
        var selectedDate = new Date(dateText);
        var day = selectedDate.toLocaleDateString('en-US', { weekday: 'long' });
        var date = selectedDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        $("#selectedDay").text(day);
        $("#selectedDate").text(date);
      }
    });
  });
</script>


<?php
include('footer.php');
?>
</div>
</div>

</body>

</html>