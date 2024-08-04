<?php
include('session.php');
include('connection.php');
include('customer_header.php');

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Your Wishlist</title>
</head>

<body>


  <br>
  <br>

  <?php
  if (!empty($_SESSION["user_id"])) {
    $counter = 0;
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM WISHLIST WHERE user_id = $user_id";
    $result = oci_parse($connection, $query);
    if (oci_execute($result)) {
      while (($row = oci_fetch_assoc($result))) {
        ++$counter;
      }
    }
  }
  ?>
  <div class="cart-titles">
    <div class="shopping-title"> YOUR WISHLIST </div>
    <span class="shopping-title-2"> There are
      <span>
        <?php echo !empty($counter) ? $counter : "0"; ?>
      </span>
      products in your Wishlist.
    </span>
  </div>
  <br>
  <br>

  <div class="shopping-cart">
    <div class="column-labels">
      <label class="product-image">Image</label>
      <label class="product-details">Product</label>
      <label class="product-price">Price</label>
      <label class="product-status">Status </label>
      <label class="product-removal">Remove</label>
      <label class="product-action">Action</label>
    </div>
    <?php
    if (!empty($_SESSION["user_id"])) {
      $user_id = $_SESSION["user_id"];
      $query = "SELECT * FROM WISHLIST WHERE user_id = $user_id";
      $result = oci_parse($connection, $query);
      if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result))) {
          $product_id = $row["PRODUCT_ID"];
          $Query = "SELECT * FROM product WHERE PRODUCT_ID = $product_id";
          $stid = oci_parse($connection, $Query);
          if (oci_execute($stid)) {
            while (($row = oci_fetch_assoc($stid))) {
              $name = $row["PRODUCT_NAME"];
              $image = $row["PRODUCT_IMAGE"];
              $price = $row["PRICE"];
              $stock = $row["STOCK"];
    ?>
              <div class="product">
                <div class="product-image">
                  <img src="trader-dashboard/images/<?php echo $image; ?>">
                </div>
                <div class="product-details">
                  <div class="product-title"><?php echo $name; ?></div>
                </div>
                <div class="product-price"><?php echo $price; ?></div>
                <div class="product-status">
                  <button class="instock-product"><?php echo ($stock > 1) ? 'In Stock' : 'Out Of Stock'; ?></button>
                </div>
                <div class="product-removal">
                  <a href="delete_from_wishlist.php?id=<?php echo $product_id; ?>&user=<?php echo $user_id; ?>">
                    <button class="remove-product">Remove</button>
                  </a>
                </div>
                <div class="product-line-action">
                      <a href="add_to_cart_icon.php?id=<?php echo $product_id; ?>&page=wishlist.php&delete_from_wishlist=1">
                          <button class="instock-product">Add to Cart</button>
                      </a>
                </div>

              </div>
    <?php
            }
          }
        }
      }
    }
    ?>

    <div class="error_message">
      <?php
      if (isset($_SESSION["cart_remove_message"])) {
        echo $_SESSION["cart_remove_message"];
        unset($_SESSION["cart_remove_message"]);
      }
      ?>
    </div>

    <style>
      .error_message {
        color: green;
        font-size: 20px;
        text-align: center;
      }
    </style>

  </div>

  <footer class="text-center text-lg-start bg-light" style="color: black">
  </footer>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

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