<?php
include('admin_header.php');

?>
<!doctype html>
<html lang="en">
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="trader-profile">Manage Product</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Quantity</th>
                            <th scope="col">Product Unit</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $query = "SELECT p.*, s.SHOP_NAME 
                          FROM product p 
                          JOIN shop s ON p.SHOP_ID = s.SHOP_ID";
                        $stid = oci_parse($connection, $query);
                        oci_execute($stid);

                        $counter = 1;
                        while (($row = oci_fetch_assoc($stid)) != false) {
                            $status = $row["PRODUCT_STATUS"];
                            if ($status == 2) {
                                continue;
                            }
                            $product_id = $row["PRODUCT_ID"];
                            $Product_name = $row["PRODUCT_NAME"];
                            $Price = $row["PRICE"];
                            $Quantity = $row["STOCK"];
                            $Category_id = $row["PRODUCT_CATEGORY_ID"];
                            $image = $row["PRODUCT_IMAGE"];
                            $maximum = $row["MAX_ORDER"];
                            $minimun = $row["MIN_ORDER"];
                            $PRODUCT_DESCRIPTION = $row["PRODUCT_DESCRIPTION"];
                            $unit = $row["PRODUCT_UNIT"];
                            $shop_name = $row["SHOP_NAME"];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $counter; ?></th>
                                <td><?php echo $shop_name; ?></td>
                                <td><?php echo $Product_name; ?></td>
                                <td><?php echo $Price; ?></td>
                                <td><?php echo $Quantity; ?></td>
                                <td><?php echo $unit; ?></td>
                                <td>
                                    <?php
                                    $query = "SELECT CATEGORY_TYPE FROM PRODUCT_CATEGORY WHERE PRODUCT_CATEGORY_ID = $Category_id";
                                    $result = oci_parse($connection, $query);
                                    if (oci_execute($result)) {
                                        while (($row = oci_fetch_array($result)) != false) { //fetching array we got from the query
                                            echo $row["CATEGORY_TYPE"];
                                        }
                                    }
                                    ?>
                                </td>
                                <td><img src="../trader-dashboard/images/<?php echo $image; ?>" style="height:70px; width:70px;"></td>


                                <td> 
                                    <a href="admin_product.php?id=<?php  echo $product_id; //edit ?>"> 
                                        <button class="btn btn-default" style="display: inline-block; padding: 0px;" data-toggle="modal" data-target="#example">
                                            <img src="./images/edit.png" width="20" />
                                        </button>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $product_id; //delete ?>">
                                        <button class="btn btn-default" style="display: inline-block; padding: 0px;">
                                            <img src="./images/delete.png" width="20" />
                                        </button>
                                    </a>
                                    <?php
                                    $task = ($status == '1') ? 'deactivate' : 'activate';
                                    ?>
                                    <a href="product_status.php?id=<?php echo $product_id; ?>&task=<?php echo $task; ?>">
                                        <button class="btn btn-default" style="background-color:<?php echo ($status == '1') ? '#FF6666' : '#a8e4a0'; ?>; margin-left: 15px">
                                            <?php echo ($status == '1') ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $counter++;
                        }
                        ?>

                    </tbody>
                </table>

                <div class="success_message">
                    <?php
                    if (isset($_SESSION['deleted_message'])) {
                        echo $_SESSION['deleted_message'];
                        unset($_SESSION['deleted_message']);
                    }
                    ?>
                </div>
                <style>
                    .success_message {
                        color: green;
                        font-size: 20px;
                        text-align: left;
                        padding-top: 15px;
                    }
                </style>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
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