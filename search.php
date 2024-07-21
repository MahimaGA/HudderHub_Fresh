<!doctype html>
<html lang="en">
<?php
include('session.php');
include('connection.php');
include('functions.php');
include('customer_header.php');

?>

<div class="wrapper">
  <nav id="sidebar">

    <div class="searchbar-product">
    </div>
    <br>
    <div class="category-product" style="margin-top: 0px;">
      <p class="cat-head"> <em> Category
          <hr style="color: cadetblue; width: 230px; height: 5px;">


        </em></p>

      <form action="search.php" method="get">
        <ul class="list-group">
          <?php

          $query = "select * from PRODUCT_CATEGORY";
          $result = oci_parse($connection, $query);
          if (oci_execute($result)) {
            while (($row = oci_fetch_assoc($result)) != false) {
              $category_id = $row["PRODUCT_CATEGORY_ID"];
              $category_name = $row["CATEGORY_TYPE"];

          ?>

              <li class="list-group-item">
                <input type="checkbox" id="<?php echo $category_id; ?>" name="category[]" value="<?php echo $category_id;  ?>" <?php if (isset($_GET["category"]) && (in_array($category_id, $_GET["category"]))) {
                                                                                                                                  echo 'checked="checked"';
                                                                                                                                } ?>>
                <?php echo $category_name;  ?>
              </li>
          <?php
            }
          }
          ?>
        </ul>

    </div>

    <div class="category-product" style="margin-top: 10px;">
      <p class="cat-head"> <em> Shop
          <hr style="color: cadetblue; width: 230px; height: 5px;">
        </em></p>

      <ul class="list-group">
        <?php

        $query = "select * from shop where status ='1'";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
          while (($row = oci_fetch_assoc($result)) != false) {

            $shop_id = $row["SHOP_ID"];
            $shop_name = $row["SHOP_NAME"];
            echo $shop_name;

        ?>
            <li class="list-group-item">
              <input type="checkbox" id="<?php echo $shop_id; ?>" name="shopname[]" value="<?php echo $shop_id; ?>" <?php if (isset($_GET["shopname"]) && in_array($shop_id, $_GET["shopname"])) {
                                                                                                                      echo 'checked="checked"';
                                                                                                                    } ?>>
              <?php
              echo $shop_name;
              ?>
            </li>
        <?php
          }
        }

        ?>

      </ul>

    </div>

    <div class="category-product" style="margin-top: 10px;">
      <p class="cat-head" style="margin-bottom: 0px;"> <em> Price
          <hr style="color: cadetblue; width: 230px; height: 5px;">
        </em></p>


      <ul class="list-group" style="border-style: none;">
        <li class="list-group-item" style="border-style: none;">

          <label> £ </label> <input type="number" id="price1" name="price1" style="width:80px;  border-color: lightgray;" placeholder="  From" <?php if (isset($_GET["price1"])) {
                                                                                                                                                  echo $_GET["price1"];
                                                                                                                                                } ?>>

          <label> £ </label> <input type="number" id="price2" name="price2" style="width:80px;  border-color: lightgray;" placeholder="  To" <?php if (isset($_GET["price2"])) {
                                                                                                                                                echo $_GET["price2"];
                                                                                                                                              } ?>>

        </li>
      </ul>
    </div>

    <div class="category-product" style="margin-top: 20px;">
      <p class="cat-head"> <em> Rating
          <hr style="color: cadetblue; width: 230px; height: 5px;">
        </em></p>

      <ul class="list-group">
        <li class="list-group-item">
          <input type="checkbox" id="rating1" name="rating[]" value="1" <?php if (isset($_GET["rating"]) && (in_array('1', $_GET["rating"]))) {
                                                                          echo 'checked="checked"';
                                                                        } ?>>
          <span class="fa fa-star checked"></span>
        </li>
        <li class="list-group-item">
          <input type="checkbox" id="rating1" name="rating[]" value="2" <?php if (isset($_GET["rating"]) && (in_array('2', $_GET["rating"]))) {
                                                                          echo 'checked="checked"';
                                                                        } ?>>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
        </li>
        <li class="list-group-item">
          <input type="checkbox" id="rating1" name="rating[]" value="3" <?php if (isset($_GET["rating"]) && (in_array('3', $_GET["rating"]))) {
                                                                          echo 'checked="checked"';
                                                                        } ?>>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
        </li>
        <li class="list-group-item">
          <input type="checkbox" id="rating1" name="rating[]" value="4" <?php if (isset($_GET["rating"]) && (in_array('4', $_GET["rating"]))) {
                                                                          echo 'checked="checked"';
                                                                        } ?>>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
        </li>
        <li class="list-group-item">
          <input type="checkbox" id="rating1" name="rating[]" value="5" <?php if (isset($_GET["rating"]) && (in_array('5', $_GET["rating"]))) {
                                                                          echo 'checked="checked"';
                                                                        } ?>>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
        </li>
      </ul>

    </div>

    <br>


    <button type="submit" class="btn btn-outline-success" name="filter" style="margin-left: 10px;">Filter</button>
    </form>
  </nav>
  <div id="content">
    <div class="container" style="margin-top: 40px;">
    </div>

    <div class="container d-flex justify-content-center mt-60">

      <div class="row">
        <?php
        if (isset($_GET["filter"])) {
          if (isset($_GET["search"]) && !empty($_GET["search"])) {
            $search = trim(strtoupper($_GET["search"]));
            $_SESSION["search"] = $search;
          }

          $search = $_SESSION["search"];
          $query =  "select * from product where CONCAT(UPPER(PRODUCT_NAME),UPPER(PRODUCT_DESCRIPTION)) like '%$search%' and PRODUCT_STATUS ='1'";
          if (isset($_GET["category"]) && !empty($_GET["category"])) {
            $category = implode(",", $_GET['category']);
            $query .= " and PRODUCT_CATEGORY_ID in($category) ";
          }
          if (isset($_GET["shopname"]) && !empty($_GET["shopname"])) {
            $shop_id = implode(",", $_GET['shopname']);
            $query .= " and SHOP_ID in($shop_id)";
          }
          if (!empty($_GET["price1"])) {
            $minimum = $_GET["price1"];
            $query .= "and PRICE >= $minimum";
          }

          if (!empty($_GET["price2"])) {
            $maximum = $_GET["price2"];
            $query .= "and PRICE <= $maximum";
          }





          $counter = 0;
          $result = oci_parse($connection, $query);
          if (oci_execute($result)) {
            while (($row = oci_fetch_assoc($result)) != false) {

              $product_id = $row["PRODUCT_ID"];
              $average_r = get_average_rating($product_id, $connection);
              if (isset($_GET['rating']) && !empty($_GET['rating'])) {
                if (!in_array($average_r, $_GET['rating'])) {
                  continue;
                }
              }
              $Product_name = $row["PRODUCT_NAME"];
              $Price = $row["PRICE"];
              $Quantity = $row["STOCK"];
              $Category_id = $row["PRODUCT_CATEGORY_ID"];
              $image = $row["PRODUCT_IMAGE"];
              $maximum = $row["MAX_ORDER"];
              $minimun = $row["MIN_ORDER"];
              $PRODUCT_DESCRIPTION = $row["PRODUCT_DESCRIPTION"];
              ++$counter;

              $discount = 0;
              $queryDiscount = "SELECT DISCOUNT_PERCENT FROM discount WHERE discount_id = (SELECT discount_id FROM product WHERE PRODUCT_ID = $product_id)";
              $stid = oci_parse($connection, $queryDiscount);
              if (oci_execute($stid)) {
                  $rowDiscount = oci_fetch_assoc($stid);
                  if ($rowDiscount) {
                      $discount = $rowDiscount["DISCOUNT_PERCENT"];
                  }
              }
        ?>
              <div class="col-md-3" style="width:auto;">
              <br><br>
                <div class="product-wrapper text-center">
                  <div class="product-img"> 
                  &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true"> <img src="trader-dashboard/images/<?php echo $image; ?>" alt=""  style="max-width:250px; max-height:325px;">
                    </a>

                    <div class="product-img mt-10">
                      <br>
                      <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true" style="color:black; text-decoration: none;  font-family: 'Josefin Sans', sans-serif; font-size: 22px;">
                        <?php echo $Product_name; ?> </a>
                    </div>
                    <div class="ratings">
                      <?php
                      $average_r = get_average_rating($product_id, $connection);
                      for ($i = 0; $i < $average_r; $i++) { ?>

                        <i class="fa fa-star rating-color"></i>
                      <?php
                      }
                      for ($i = 0; $i < (5 - $average_r); $i++) {
                      ?>
                        <i class="fa fa-star"></i>
                      <?php
                      }
                      ?>

                    </div>
                    </a>
                    <span class="text-center">
                    <span class="pound-sign"> £</span>
                              <?php echo $Price; ?>
                              <?php if ($discount != 0) { ?>
                                  <br>
                                  <span class="discount">
                                      <?php echo $discount . "% OFF"; ?>
                                  </span>
                              <?php } ?>
                    </span>
                    <div class="product-action" style="margin-bottom: 30px;">
                      <div class="product-action-style">
                        <a href="add_to_wishlist.php?id=<?php echo $product_id; ?>&page=shop.php"> <img src="images/icon/heart.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;"> </a>
<a href="add_to_cart_icon.php?id=<?php echo $product_id; ?>&page=shop.php"> <img src="images/icon/shopping-bag.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;"> </a>               
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
        <?php
            }
          }
        }


        ?>

        <?php

        if ($counter == 0) {
        ?>
          <div class="no_result_found">
            <p>No result found</p>
          </div>
        <?php
        }
        ?>


      </div>
    </div>
  </div>
</div>



</div>
<br>
</div>
<?php
include("footer.php");
?>
<script>
  $(function() {
    $("#price-range").slider({
      step: 500,
      range: true,
      min: 0,
      max: 20000,
      values: [0, 20000],
      slide: function(event, ui) {
        $("#priceRange").val(ui.values[0] + " - " + ui.values[1]);
      }
    });
    $("#priceRange").val($("#price-range").slider("values", 0) + " - " + $("#price-range").slider("values", 1));

  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>