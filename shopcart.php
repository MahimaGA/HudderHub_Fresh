<?php
include('session.php');
include('connection.php');
include('functions.php');
include('customer_header.php');

if (isset($_POST["update"])) {
  $user_id = $_SESSION["user_id"];
  $product_id = $_POST["pid"];
  $quantity = $_POST["q"];
  $_SESSION["pro_id"] = $product_id;

  $stock = get_stock_quantity($connection, $product_id);
  $maximum = get_maximum_quantity($connection, $product_id);
  $minimum = get_minimum_quantity($connection, $product_id);

  if ($quantity > $stock) {
    $_SESSION["quantity_error_message"] = "You choose quantity more than available in stock";
?>
    <script>
      window.location.href = window.location.href
    </script>
  <?php
  } elseif ($quantity > $maximum) {
    $_SESSION["quantity_error_message"] = "The maximum quantity for this product is $maximum ";
  ?>
    <script>
      window.location.href = window.location.href
    </script>
  <?php
  } elseif ($quantity < $minimum) {
    $_SESSION["quantity_error_message"] = "At least $minimum has to be purchased for this product";
  ?>
    <script>
      window.location.href = window.location.href
    </script>
    <?php
  } else {
    $query = "update cart set PRODUCT_QUANTITY = $quantity where product_id = $product_id and user_id=$user_id and purchase=0";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
      if (oci_num_rows($result) != false) {
    ?>
        <script>
          window.location.href = window.location.href
        </script>
<?php
      }
    }
  }
}

?>

<!doctype html>
<html lang="en">
<br>
<br>

<!-- start of cart -->
<?php
if (!empty($_SESSION["user_id"])) {
  $counter = 0;
  $user_id = $_SESSION["user_id"];
  $query = "select * from cart where user_id= $user_id and purchase=0";
  $result = oci_parse($connection, $query);
  if (oci_execute($result)) {

    while (($row = oci_fetch_assoc($result))) {
      ++$counter;
    }
  }
}
?>
<div class="cart-titles">
  <div class="shopping-title"> YOUR CART </div>
  <span class="shopping-title-2"> There are <?php
                                            if (!empty($counter)) {
                                              echo  $counter;
                                            } else {
                                              echo "0";
                                            }
                                            ?> products in your cart.</span>

</div>
<br>
<br>
<?php
if (!empty($counter)) {
  if ($counter != 0) {

?>

    <div class="shopping-cart">
      <div class="column-labels">
        <label class="product-image">Image</label>
        <label class="product-details">Product</label>
        <label class="product-price">Price</label>
        <label class="product-quantity">Quantity</label>
        <label class="product-removal">Remove</label>
        <label class="product-line-price">Subtotal</label>
      </div>

      <?php
      if (!empty($_SESSION["user_id"])) {

        $user_id = $_SESSION["user_id"];
        $query = "select * from cart where user_id= $user_id and purchase=0";
        $result = oci_parse($connection, $query);

        if (oci_execute($result)) {
          $total = 0;
          while (($row = oci_fetch_assoc($result)) != false) {
            $product_id = $row["PRODUCT_ID"];
            $quantity = $row["PRODUCT_QUANTITY"];

            $discountc = 0;
            $discount = 0;
            $Query = "SELECT * FROM product JOIN discount ON product.discount_id = discount.discount_id WHERE product.discount_id IS NOT NULL AND product.PRODUCT_ID = $product_id";
            $stid = oci_parse($connection, $Query);
            if (oci_execute($stid)) {
              while (($row = oci_fetch_assoc($stid)) != false) {
                $discount = $row["DISCOUNT_PERCENT"];

                ++$discountc;
              }
            }

            $Query = "select * from product where PRODUCT_ID = $product_id";
            $stid = oci_parse($connection, $Query);

            if (oci_execute($stid)) {
              while (($row = oci_fetch_assoc($stid)) != false) {
                $name = $row["PRODUCT_NAME"];
                $image = $row["PRODUCT_IMAGE"];
                $price = $row["PRICE"];
                $total = $total + (($price - ($price * $discount) / 100) * $quantity);

      ?>

                <div class="product">
                  <div class="product-image">
                    <img src="trader-dashboard/images/<?php echo $image; ?>">
                  </div>

                  <div class="product-details">
                    <div class="product-title"><?php echo $name; ?></div>
                  </div>
                  <div class="product-price">
                    <?php if ($discountc != 0) {
                      echo "<small style='color:red;'><s>$price</s></small><br>";
                      echo "\t\t£" . ($price - (($price) * $discount / 100));
                    } else {
                      echo $price;
                    } ?>
                  </div>
                  <form action="" method="post">
                    <div class="product-quantity">
                      <input type="hidden" value="<?php echo $product_id; ?>" name="pid" min="1">
                      <input type="number" value="<?php echo $quantity; ?>" name="q" min="1">
                      <button type="submit" name="update"><i class='fas fa-edit'></i></button>


                      <div class="error_message">
                        <?php
                        if (isset($_SESSION["pro_id"]) && $product_id ==  $_SESSION["pro_id"]) {
                          if (isset($_SESSION["quantity_error_message"])) {
                            echo $_SESSION["quantity_error_message"];
                            unset($_SESSION["quantity_error_message"]);
                          }
                        }
                        ?>
                      </div>

                    </div>
                  </form>
                  <div class="product-removal">
                    <a href="delete_from_cart.php?id=<?php echo $product_id; ?>&user=<?php echo $user_id; ?>"><button class="remove-product">
                        Remove
                      </button></a>


                  </div>
                  <div class="product-line-price"><?php echo ($price - (($price * $discount) / 100)) * $quantity; ?></div>
                </div>

                </form>
      <?php
              }
            }
          }
        }
      }


      ?>


      <div class="success_message">
        <?php
        if (isset($_SESSION["cart_remove_message"])) {
          echo $_SESSION["cart_remove_message"];
          unset($_SESSION["cart_remove_message"]);
        }
        ?>
      </div>
      <div class="error_message">
        <?php
        if (isset($_SESSION["quantity_message"])) {
          echo $_SESSION["quantity_message"];
          unset($_SESSION["quantity_message"]);
        }
        ?>
      </div>

      <style>
        .success_message {

          color: green;
          font-size: 20px;
          text-align: center;
        }

        .error_message {

          color: red;
          font-size: 14px;
          text-align: center;

        }
      </style>


      <div class="totals">
        <div class="totals-item">
          <label>Subtotal</label>
          <div class="totals-value" id="cart-subtotal"><?php echo $total; ?></div>
        </div>
        <div class="totals-item">
          <label>Discount (0%)</label>
          <div class="totals-value" id="cart-tax">0.00</div>
        </div>

        <div class="totals-item totals-item-total">
          <label>Grand Total</label>
          <div class="totals-value" id="cart-total"><?php echo $total; ?></div>
        </div>
      </div>

      <a href="checkout.php"><button class="checkout">Checkout</button></a>

    </div>


    <br>

    <br>
<?php
  }
}

?>
<?php
include('footer.php');
?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
  var disRate = 20.05;
  var fadeTime = 300;
  $(".product-quantity input").change(function() {
    updateQuantity(this);
  });

  $(".product-removal button").click(function() {
    removeItem(this);
  });
  function recalculateCart() {
    var subtotal = 0;
    $(".product").each(function() {
      subtotal += parseFloat($(this).children(".product-line-price").text());
    });
    var dis = subtotal - disRate;
    var total = subtotal - dis;
    $(".totals-value").fadeOut(fadeTime, function() {
      $("#cart-subtotal").html(subtotal.toFixed(2));
      $("#cart-tax").html(dis.toFixed(2));
      $("#cart-total").html(total.toFixed(2));
      if (total == 0) {
        $(".checkout").fadeOut(fadeTime);
      } else {
        $(".checkout").fadeIn(fadeTime);
      }
      $(".totals-value").fadeIn(fadeTime);
    });
  }
  function updateQuantity(quantityInput) {
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children(".product-price").text());
    var quantity = $(quantityInput).val();
    var linePrice = price * quantity;
    productRow.children(".product-line-price").each(function() {
      $(this).fadeOut(fadeTime, function() {
        $(this).text(linePrice.toFixed(2));
        recalculateCart();
        $(this).fadeIn(fadeTime);
      });
    });
  }
  function removeItem(removeButton) {
    var productRow = $(removeButton).parent().parent();
    productRow.slideUp(fadeTime, function() {
      productRow.remove();
      recalculateCart();
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>


</body>

</html>