<?php
include('session.php');
include('trader_header.php');


?>

<!doctype html>
<html lang="en">

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="trader-profile">Manage Shop</h2>
            </div>
        </div>

        <?php
        if (isset($_GET["id"])) {
            $shop_id = $_GET["id"];
            $query = "select * from shop where SHOP_ID = $shop_id";
            $result = oci_parse($connection, $query);
            if (oci_execute($result)) {
                while (($row = oci_fetch_assoc($result)) != false) {
                    $shop_id = $row["SHOP_ID"];
                    $shop_name = $row["SHOP_NAME"];
                    $shop_location = $row["SHOP_LOCATION"];
                    $image = $row["SHOP_LOGO"];

                    $_SESSION["s_shop_id"] = $shop_id;
                    $_SESSION["s_shop_name"] = $shop_name;
                    $_SESSION["s_shop_location"] = $shop_location;
                    $_SESSION["s_image"] = $image;
                }
            }
        }
        ?>
        <form action="update_shop.php" method="post" enctype='multipart/form-data'>



            <div class="row mt-2">
                <div class="col-md-12">
                    <label class="labels"></label>
                    <input type="hidden" class="form-control" value="<?php echo $_SESSION["s_shop_id"]; ?>" name="shop_id">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">Shop Name* </label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION["s_shop_name"]; ?>" name="shopname">
                    <div class="error_message">
                    <?php
                if (isset($_SESSION['shopname_error'])) {
                    echo $_SESSION['shopname_error'];
                    unset($_SESSION['shopname_error']);
                }
                ?>
                    </div>
                </div>
            </div>




            <div class=" row mt-2">
                <div class="col-md-6">
                    <label class="labels">Shop Location* </label>
                    <input type="hidden" class="form-control" value="<?php echo $_SESSION["s_image"]; ?>" name="image"><input type="text" class="form-control" value="<?php echo $_SESSION["s_shop_location"]; ?>" name="location">
                </div>
            </div>


            <div class=" row mt-2">
                <div class="col-md-6">
                    <label class="labels">Shop Logo </label> <label for="img" class="labels">(select image):</label>

                    <br>
                    <input type="file" id="img" name="file">
                </div>

            </div>


            <div class="row mt-4">
                <div class="col-md-6">

                    <button class="btn btn-dark profile-button" id="tbutton" type="submit" name="edit_shop">Update
                        Shop</button>
                </div>
            </div>

    </div>
    </form>



    <div class="error_message">
        <?php
        if (isset($_SESSION['empty_error'])) {
            echo $_SESSION['empty_error'];
            unset($_SESSION['empty_error']);
        }
        ?>
    </div>
    <div class="error_message">
            <?php
            if (isset($_SESSION['image_extension'])) {
                echo $_SESSION['image_extension'];
                unset($_SESSION['image_extension']);
            }
            ?>
    </div>
    <div class="error_message">
            <?php
            if (isset($_SESSION['image_extension'])) {
                echo $_SESSION['image_extension'];
                unset($_SESSION['image_extension']);
            }
            ?>
        </div>



    <style>
        .error_message {
            color: red;
            font-size: 20px;
            margin-left: 170px;
        }
    </style>




    <!-- Popper.JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
