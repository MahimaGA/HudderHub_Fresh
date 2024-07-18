<?php
include('session.php');
include('functions.php');
include('connection.php');
include('customer_header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="container" style="margin-top:20px">
        <div class="row">
            <div class="col-3">
                <div class="banner1">
                    <div class="d-sm-none d-md-block d-none d-sm-block">
                        <img src="images/banner1.gif" class="img-fluid" id="banners" style="max-width: 100%;">
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="banner2" style="margin-right:20px;">
                    <img src="images/banner1.jpg" class="img-fluid" id="banners">
                    <div class="d-flex align-items-center">
                        <div class="banner-content">
                            <h3 class="bannerc2">Your daily need products!</h3>
                            <br>
                            <a href="shop.php" class="btn btn-dark">Get started.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="product-area product-style-2 section-space-y-axis-100">
        <div class="container">
            <div class="section-title text-center pb-55">
                <div class="category-head" style="margin-bottom:20px">
                    <h1> New Arrival! </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center mt-60">
        <div class="row">
            <?php
            $query = "SELECT * FROM (SELECT * FROM product WHERE PRODUCT_STATUS = '1' ORDER BY PRODUCT_ID DESC) WHERE ROWNUM <= 2";
            $result = oci_parse($connection, $query);
            if (oci_execute($result)) {
                while (($rowProduct = oci_fetch_assoc($result)) != false) {
                    $id = $rowProduct["PRODUCT_ID"];
                    $name = $rowProduct["PRODUCT_NAME"];
                    $image = $rowProduct["PRODUCT_IMAGE"];
                    $price = $rowProduct["PRICE"];
                    $discount = 0;
                    $queryDiscount = "SELECT * FROM product JOIN discount ON product.discount_id = discount.discount_id WHERE product.discount_id IS NOT NULL AND product.PRODUCT_ID = $id";
                    $stid = oci_parse($connection, $queryDiscount);
                    if (oci_execute($stid)) {
                        $rowDiscount = oci_fetch_assoc($stid);
                        if ($rowDiscount) {
                            $discount = $rowDiscount["DISCOUNT_PERCENT"];
                        }
                    }
            ?>
                    <div class="col-md-3" style="width:auto;">
                        <div class="product-wrapper text-center">
                            <div class="product-img">
                                <a href="productdetail.php?id=<?php echo $id; ?>" data-abc="true">
                                    <img src="trader-dashboard/images/<?php echo $image; ?>" alt="" style="max-width:250px; max-height:325px;">
                                </a>
                                <div class="product-img mt-10">
                                    <br>
                                    <a href="productdetail.php?id=<?php echo $id; ?>" data-abc="true" style="color:black; text-decoration: none;  font-family: 'Josefin Sans', sans-serif; font-size: 22px;">
                                        <?php echo $name ?> </a>
                                </div>
                                <span class="text-center">
                                    <span class="pound-sign">£</span>
                                    <?php echo $price; ?>
                                    <?php if ($discount != 0) { ?>
                                        <br>
                                        <span class="discount">
                                            <?php echo $discount . "% OFF"; ?>
                                        </span>
                                    <?php } ?>
                                </span>
                                <br>
                                <div class="product-action" style="width:100%; right:20%;">
                                    <div class="product-action-style">
                                    <a href="add_to_wishlist.php?id=<?php echo $id; ?>&page=index.php"> <img src="images/icon/heart.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;"> </a>
                                        <a href="add_to_cart_icon.php?id=<?php echo $id; ?>&page=index.php"> <img src="images/icon/shopping-bag.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;"> </a>
                                    </div>
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

                <body style="background-color:white;">
                    <br>
                    <br>


                    <div class="product-area product-style-2 section-space-y-axis-100">
                        <div class="container">
                            <div class="section-title text-center pb-55">
                                <div class="category-head" style="margin-bottom:20px">
                                    <h1>Top Rated Products!</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center mt-60">
                        <div class="row">
                            <?php
                            $query = "SELECT a.* FROM (SELECT PRODUCT_ID, PRICE, PRODUCT_NAME, COUNT_SUM / COUNT_TOTAL AS AVERAGE 
                FROM (SELECT COUNT(*) AS COUNT_TOTAL, P.PRODUCT_ID, PRICE, PRODUCT_NAME, SUM(REVIEW_RATING) AS COUNT_SUM 
                      FROM PRODUCT P 
                      JOIN REVIEW R ON R.PRODUCT_ID = P.PRODUCT_ID 
                      WHERE PRODUCT_STATUS = '1' 
                      GROUP BY P.PRODUCT_ID, PRICE, PRODUCT_NAME) 
                ORDER BY AVERAGE DESC) a 
                WHERE ROWNUM <= 4";

                            $result = oci_parse($connection, $query);
                            if (oci_execute($result)) {
                                while (($row = oci_fetch_assoc($result)) != false) {
                                    $product_id = $row["PRODUCT_ID"];
                                    $price = $row["PRICE"];
                                    $name = $row["PRODUCT_NAME"];
                                    $image = get_product_image($connection, $product_id);
                                    $discount = 0;
                                    $queryDiscount = "SELECT * FROM product JOIN discount ON product.discount_id = discount.discount_id WHERE product.discount_id IS NOT NULL AND product.PRODUCT_ID = $product_id";
                                    $stid = oci_parse($connection, $queryDiscount);
                                    if (oci_execute($stid)) {
                                        $rowDiscount = oci_fetch_assoc($stid);
                                        if ($rowDiscount) {
                                            $discount = $rowDiscount["DISCOUNT_PERCENT"];
                        }
                    }

                            ?>
                                    <div class="col-md-3" style="width:auto;">
                                        <div class="product-wrapper text-center">
                                            <div class="product-img">
                                                <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true">
                                                    <img src="trader-dashboard/images/<?php echo $image; ?>" alt="" style="max-width:250px; max-height:325px;">
                                                </a>

                                                <div class="product-img mt-10">
                                                    <br>
                                                    <a href="productdetail.php?id=<?php echo $product_id; ?>" data-abc="true" style="color:black; text-decoration: none;  font-family: 'Josefin Sans', sans-serif; font-size: 22px;">
                                                        <?php echo $name; ?>
                                                    </a>
                                                </div>

                                                <div class="ratings">
                                                    <?php
                                                    $average_r = get_average_rating($product_id, $connection);
                                                    for ($i = 0; $i < $average_r; $i++) { ?>
                                                        <i class="fa fa-star rating-color"></i>
                                                    <?php }
                                                    for ($i = 0; $i < (5 - $average_r); $i++) { ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php } ?>
                                                </div>

                                                <span class="text-center">
                                                <span class="pound-sign">£</span>
                                                    <?php echo $price; ?>
                                                    <?php if ($discount != 0) { ?>
                                                        <br>
                                                        <span class="discount">
                                                            <?php echo $discount . "% OFF"; ?>
                                                        </span>
                                                    <?php } ?>
                                                </span>

                                                <div class="product-action" style="margin-bottom: 30px;">
                                                    <div class="product-action-style">
                                                        <a href="add_to_wishlist.php?id=<?php echo $product_id; ?>&page=index.php">
                                                            <img src="images/icon/heart.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;">
                                                        </a>
                                                        <a href="add_to_cart_icon.php?id=<?php echo $product_id; ?>&page=index.php">
                                                            <img src="images/icon/shopping-bag.png" alt="" srcset="" style="max-width: 20px; max-height: 20px;">
                                                        </a>

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
                    <br><br><br>
                    <?php
                    include('footer.php');
                    ?>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
                    </script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
                    </script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
                    </script>
                </body>

</html>