<?php
include('functions.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HudderHub Fresh</title>

  <?php
include('customer_header.php');
if (isset($_GET["id"]) || !empty($_SESSION['id'])) {
  if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    unset($_SESSION['id']);
  }
  if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }
  $query = "SELECT * FROM product WHERE PRODUCT_ID = $id";
  $result = oci_parse($connection, $query);
  if (oci_execute($result)) {
    while (($row = oci_fetch_assoc($result)) != false) {

      $Product_name = $row["PRODUCT_NAME"];
      $Price = $row["PRICE"];
      $Quantity = $row["STOCK"];
      $Category_id = $row["PRODUCT_CATEGORY_ID"];
      $image = $row["PRODUCT_IMAGE"];
      $maximum = $row["MAX_ORDER"];
      $minimun = $row["MIN_ORDER"];
      $PRODUCT_DESCRIPTION = $row["PRODUCT_DESCRIPTION"];
      $allergy = $row["ALLERGY_INFORMATION"];
      $shop_id = $row["SHOP_ID"];
      $unit = $row["PRODUCT_UNIT"];
      $product_id = $row["PRODUCT_ID"];
      $discount = 0;
      $queryDiscount = "SELECT DISCOUNT_PERCENT FROM discount WHERE discount_id IN (SELECT discount_id FROM product WHERE PRODUCT_ID = $product_id)";
      $stid = oci_parse($connection, $queryDiscount);
      if (oci_execute($stid)) {
        $rowDiscount = oci_fetch_assoc($stid);
        if ($rowDiscount) {
          $discount = $rowDiscount["DISCOUNT_PERCENT"];
        }
      }
    }
  }
}
  $_SESSION['id'] = $id;

  if (isset($_POST["review"])) {
    $user_id = $_SESSION['user_id'];
    $rate = $_POST["rating"];
    $review = $_POST["comment"];
    $review_date = date("d-m-Y");
    $review = "'" . str_replace("'", "''", $review) . "'";
    $query = "insert into review (REVIEW,REVIEW_RATING,REVIEW_DATE,product_id,user_id)
   values(:commentsss,:ratingg,to_date(:review_date,'DD/MM/YYYY'),:productid,:userid)";
    $result = oci_parse($connection, $query);

    oci_bind_by_name($result, ':commentsss', $review);
    oci_bind_by_name($result, ':ratingg', $rate);
    oci_bind_by_name($result, ':review_date', $review_date);
    oci_bind_by_name($result, ':productid', $id);
    oci_bind_by_name($result, ':userid', $user_id);

    if (oci_execute($result)) {
  ?>
      <script>
        window.location.href = window.location.href
      </script>
  <?php
    }
  }

  ?>
  <div class="container">
    <div class="row">
      <div class="offset-2 col-md-4">
        <div class="productimage-detail">
          <img class="img-fluid" src="trader-dashboard/images/<?php echo $image; ?>" alt="" id="productimage-detail"  style="max-width:250px; max-height:325px;">
        </div>
      </div>

      <div class="col-md-6">
        <div class="stock">
          <?php
          if (!empty($Quantity)) {
            if ($Quantity != 1) {
          ?>
              <span>In Stock</span>
            <?php
            } else {
            ?>
              <span>Out Of Stock</span>
          <?php
            }
          }
          ?>
        </div>
        <br>
        <div class="projectdes">
          <?php
          echo $Product_name;
          ?>

        </div>



        <div class="rating-star">
          <?php
          $average_r = get_average_rating($id, $connection);
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


        <div class="projectprice">
          <span> <?php  $discountedPrice = $Price - ($Price * $discount / 100);
              if ($discount != 0) {
                echo "<small style='color:red;'><s> £$Price</s></small>";
                ?>/<?php
                echo $unit;
                echo "<br>\t\t£" .$discountedPrice;
              } else {
                echo "<br>\t\t£" .$Price; 
              }
        ?>/
            <span> <?php
                    echo $unit;
                    ?>

            </span>
        </div>
        <br>
        <div class="productdesc">
          <br>
          <span class="detailtitles"> Description: </span>
          <p>
            <?php
            echo $PRODUCT_DESCRIPTION;
            ?>

          </p>

        </div>
        <div class="productallergy">
          <?php
          if (!empty($allergy)) {
          ?>

            <span class="detailtitles"> Allergy Information: </span>
            <p>
              <?php
              echo $allergy;
              ?>
            </p>
          <?php
          }
          ?>
        </div>
        <br>
        <form action="add_to_cart.php" method="post">
          <div class="container">
              <div class="row">
                  <div class="col-1" style="padding: 0px; margin-right: 35px;">
                      <div class="quantitypd">
                          <input id="quantity" name="quantity" type="number" value="<?php echo $minimun; ?>" class="form-control quantity-input" style="width:65px;" min="1">
                      </div>
                  </div>
                  <div class="col-6" style="margin: 0px; padding: 0px; display: inline-block;">
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <button type="submit" class="btn btn-outline-success">Add to Cart</button>

      </form>

            <a href="add_to_wishlist.php?id=<?php echo $id; ?>&page=productdetail.php"><button type="button" class="btn" style="margin-left:10px; border-style: solid; border-color: green;"> <img src="images/icon/heart.png" alt="" srcset="" style="max-widht:25px; max-height:25px;">
                </button></a>
                </div>
              </div>
          </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <br> <br>


  <div class="container">

    <div class="row">
      <div class="col-md-9">


        <div class="container">
          <div id="reviews" class="review-section">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h4 class="m-0"> <?php echo get_rating_count($connection, $id); ?> Reviews</h4>

            </div>
            <div class="row">
              <div class="col-md-9">
                <table class="stars-counters">
                  <tbody>
                    <tr class="">
                      <td>
                        <span>
                          <button class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter">5
                            Stars</button>
                        </span>
                      </td>
                      <td class="progress-bar-container">
                        <div class="fit-progressbar fit-progressbar-bar star-progress-bar">
                          <div class="fit-progressbar-background">
                            <span class="progress-fill" style="width: <?php if (get_rating_count($connection, $id) == 0) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo ((get_5star_rating($connection, $id) / get_rating_count($connection, $id)) * 100);
                                                                      } ?>%;"></span>
                          </div>
                        </div>
                      </td>
                      <td class="star-num">(<?php echo get_5star_rating($connection, $id); ?>)</td>
                    </tr>
                    <tr class="">
                      <td>
                        <span>
                          <button class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter">4
                            Stars</button>
                        </span>
                      </td>
                      <td class="progress-bar-container">
                        <div class="fit-progressbar fit-progressbar-bar star-progress-bar">
                          <div class="fit-progressbar-background">
                            <span class="progress-fill" style="width: <?php if (get_rating_count($connection, $id) == 0) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo ((get_4star_rating($connection, $id) / get_rating_count($connection, $id)) * 100);
                                                                      } ?>%;"></span>
                          </div>
                        </div>
                      </td>
                      <td class="star-num">(<?php echo get_4star_rating($connection, $id) ?>)</td>
                    </tr>
                    <tr class="">
                      <td>
                        <span>
                          <button class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter">3
                            Stars</button>
                        </span>
                      </td>
                      <td class="progress-bar-container">
                        <div class="fit-progressbar fit-progressbar-bar star-progress-bar">
                          <div class="fit-progressbar-background">
                            <span class="progress-fill" style="width: <?php if (get_rating_count($connection, $id) == 0) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo ((get_3star_rating($connection, $id) / get_rating_count($connection, $id)) * 100);
                                                                      } ?>%;"></span>
                          </div>
                        </div>
                      </td>
                      <td class="star-num">(<?php echo get_3star_rating($connection, $id) ?>)</td>
                    </tr>
                    <tr class="">
                      <td>
                        <span>
                          <button class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter">2
                            Stars</button>
                        </span>
                      </td>
                      <td class="progress-bar-container">
                        <div class="fit-progressbar fit-progressbar-bar star-progress-bar">
                          <div class="fit-progressbar-background">
                            <span class="progress-fill" style="width: <?php if (get_rating_count($connection, $id) == 0) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo ((get_2star_rating($connection, $id) / get_rating_count($connection, $id)) * 100);
                                                                      } ?>%;"></span>
                          </div>
                        </div>
                      </td>
                      <td class="star-num">(<?php echo get_2star_rating($connection, $id) ?>)</td>
                    </tr>
                    <tr class="">
                      <td>
                        <span>
                          <button class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter">1
                            Stars</button>
                        </span>
                      </td>
                      <td class="progress-bar-container">
                        <div class="fit-progressbar fit-progressbar-bar star-progress-bar">
                          <div class="fit-progressbar-background">
                            <span class="progress-fill" style="width: <?php if (get_rating_count($connection, $id) == 0) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo ((get_1star_rating($connection, $id) / get_rating_count($connection, $id)) * 100);
                                                                      } ?>%;"></span>
                          </div>
                        </div>
                      </td>
                      <td class="star-num">(<?php echo get_1star_rating($connection, $id) ?>)</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>

        </div>

      </div>
      <?php
      $query = "select * from shop where SHOP_ID =$shop_id";
      $result = oci_parse($connection, $query);
      if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
          $logo = $row["SHOP_LOGO"];
        }
      }
      ?>

      <div class="col-md-3">
        <span class="detailtitles2" style="margin-left: 40px;"> Vendor: </span>
        <div class="vendorimage">
          <img src="trader-dashboard/images/vendors/<?php echo $logo; ?>" alt="<?php echo $shop_id; ?>" srcset="" style="height:100px; width:100px;">
        </div>
      </div>
    </div>
  </div>






  <div class="container">
    <div class="row">


      <div class="col-md-8 offset-1">
        <div class="comment-section">
          <div class="container">
            <div class="review">
              <div class="comment-section">


                <?php
                if (isset($_SESSION['user_id'])) {
                  $pid = array();
                  $count = 0;
                  $uid = $_SESSION['user_id'];
                  $query = "select * from payment where USER_ID=$uid";
                  $result = oci_parse($connection, $query);
                  $count = 0;
                  if (oci_execute($result)) {
                    while (($row = oci_fetch_assoc($result)) != false) {
                      $o_id = $row["ORDER_ID"];
                      $pid[$count] = get_product_id($connection, $o_id);
                      ++$count;
                    }
                  }
                }
                ?>

                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="
                  <?php
                  if (isset($_SESSION['user_id'])) {
                    if (in_array($id, $pid)) {
                      echo '#exampleModalCenter';
                    } else {
                      echo "#exampleModalCenter2";
                    }
                  } else {
                    echo '#exampleModalCenter1';
                  } ?>
                  ">
                  Write a Review
                </button>
                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Sign in first!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        You need to be logged in first to add this item to write a review.
                      </div>
                      <div class="modal-footer">

                        <button type="button" class="btn btn-success">Close </button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Purchase the product first!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        You need to purchase the product first to add this item to write a review.
                      </div>
                      <div class="modal-footer">

                        <button type="button" class="btn btn-success">Close </button>
                      </div>
                    </div>
                  </div>
                </div>





                <style>
                  input[type=text] {
                    width: 100%;
                    padding: 12px 20px;
                    margin: 8px 0;
                    box-sizing: border-box;
                    border: 3px solid #ccc;
                    -webkit-transition: 0.5s;
                    transition: 0.5s;
                    outline: none;
                  }

                  input[type=text]:focus {
                    border: 3px solid #555;
                  }
                </style>


                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Write a review!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">



                        <form method="post" action="productdetail.php">


                          <br>
                          <div class="star-rating js-star-rating" style="margin-top:0px; margin-bottom: 0px;">
                            <input class="star-rating__input" type="radio" name="rating" value="1"><i class="star-rating__star"></i>
                            <input class="star-rating__input" type="radio" name="rating" value="2"><i class="star-rating__star"></i>
                            <input class="star-rating__input" type="radio" name="rating" value="3"><i class="star-rating__star"></i>
                            <input class="star-rating__input" type="radio" name="rating" value="4"><i class="star-rating__star"></i>
                            <input class="star-rating__input" type="radio" name="rating" value="5"><i class="star-rating__star"></i>
                            <div class="current-rating current-rating--3-5 js-current-rating"><i class="star-rating__star">AAA</i></div>
                          </div>

                          <br>


                          <label class="labels">Write your review </label>
                          <br>


                          <input type="text" name="comment" class="form-control" value="" style="height:100px; margin-top: 20px;">

                          <div class="modal-footer">

                            <button type="submit" name="review" class="btn btn-success">Post </button>
                          </div>
                        </form>




                      </div>

                    </div>
                  </div>
                </div>
                <br>
                <br>
                <?php

                $query = "select * from review where PRODUCT_ID =$id order by REVIEW_ID asc";
                $result = oci_parse($connection, $query);
                if (oci_execute($result)) {
                  while (($row = oci_fetch_assoc($result)) != false) {

                    if (empty($row["REVIEW"])) {
                      continue;
                    }
                    $REVIEW_RATING = $row["REVIEW_RATING"];
                    $username = get_customer_name($connection, $row["USER_ID"]);

                ?>
                    <div class="media media-review">
                      <div class="media-user"><img src="images/user.png" alt=""></div>
                      <div class="media-body">
                        <div class="M-flex">
                          <h2 class="title">
                            <div class="namereview">
                              <span> <?php echo $username; ?> </span>
                            </div>

                          </h2>
                          <div class="rating-row">
                            <ul>
                              <?php
                              for ($i = 0; $i < $REVIEW_RATING; $i++) { ?>

                                <i class="fa fa-star rating-color"></i>
                              <?php
                              }
                              for ($i = 0; $i < (5 - $REVIEW_RATING); $i++) {
                              ?>
                                <i class="fa fa-star"></i>
                              <?php
                              }
                              ?>
                            </ul>


                            <div class="time">
                              <span class="timeno"> <?php echo $row["REVIEW_DATE"]; ?></span>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="description"><?php echo $row["REVIEW"]; ?> </div>
                      </div>
                    </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="container d-flex justify-content-center mt-100">
    <div class="row" style="margin-left:80px;">

      <h1 style="font-family: 'Josefin Sans', sans-serif;align:center;"> Related Products</h1>
      <br>
      <br>
      <br>
      <?php


      $query = "select * from  (select * from product where PRODUCT_STATUS ='1' and PRODUCT_ID != $id and PRODUCT_CATEGORY_ID =$Category_id ) where ROWNUM <= 4";
      $result = oci_parse($connection, $query);
      if (oci_execute($result)) {
        while (($row = oci_fetch_assoc($result)) != false) {
          $product_id = $row["PRODUCT_ID"];
          $Product_name = $row["PRODUCT_NAME"];
          $Price = $row["PRICE"];
          $Quantity = $row["STOCK"];
          $image = $row["PRODUCT_IMAGE"];

      ?>
          <div class="col-md-3" style="width:auto;">
            <div class="product-wrapper text-center">
              <div class="product-img"> <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true"> <img src="trader-dashboard/images/<?php echo $image; ?>" alt=""  style="max-width:250px; max-height:325px;">
                </a>

                <div class="product-img mt-10">
                  <br>
                  <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true" style="color:black; text-decoration: none;  font-family: 'Josefin Sans', sans-serif; font-size: 22px;">
                    <?php
                    echo $Product_name;
                    ?></a>
                </div>

                <span class="text-center">
                  <span class="pound-sign"> £</span>
                  <?php echo $Price; ?><br>
                </span>

                <div class="product-action">
                  <div class="product-action-style">
                    <a href="add_to_wishlist.php?id=<?php echo $product_id; ?>&page=productdetail.php"> <img src="images/icon/heart.png" alt="" srcset="" style="max-width:20px; max-height:20px;"> </a>

                    <a href="#" onclick="addToCart(<?php echo $id; ?>); return false;"><img src="images/icon/shopping-bag.png" alt="" style="max-width: 20px; max-height: 20px;"></a>                                    



                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <br>
  <br>
  <?php
  include('footer.php');
  ?>



  <script>
    $('.js-star-rating').on('change', 'input', function() {
      $('.js-current-rating')
        .removeClass()
        .addClass('current-rating js-current-rating current-rating--' + this.value);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>

  </body>

</html>