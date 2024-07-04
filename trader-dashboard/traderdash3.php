<?php
include('trader_header.php')
?>
<!doctype html>
<html lang="en">
</body>

<h2 class="trader-profile"> Add Product</h2>
<form action="add_product.php" method="post" enctype='multipart/form-data'>
    <div class="row mt-2">
        <div class="col-md-6">
            <label class="labels">Product Name* </label>
            <input type="text" class="form-control" name="product_name">
        </div>

        <div class="error_message">
            <?php
            if (isset($_SESSION['product_error_message'])) {
                echo $_SESSION['product_error_message'];
                unset($_SESSION['product_error_message']);
            }
            ?>
        </div>
        <div class="col-md-6"><label class="labels">Product Price*</label><input type="number" class="form-control" name="price" min="1"></div>
    </div>

    <br>
    <div class=" row mt-2">
        <div class="col-md-6"><label class="labels">Product Quantity* </label><input type="number" class="form-control" name="quantity" min="1"></div>
        <div class="col-md-6"><label class="labels">Product Unit*</label>
            <div class="pk-form">
                <select name="unit" id="unit" class="option pickout" placeholder="Select a category">
                    <option value="kg">kg</option>
                    <option value="lbs">lbs</option>
                    <option value="pound">pound</option>
                    <option value="ltr">ltr</option>
                    <option value="pcs">pcs</option>
                </select>
            </div>
        </div>
        <div class="col-md-6"><label class="labels">Product Category*</label>


            <div class="pk-form">
                <select name="option" id="option" class="option pickout" placeholder="Select a category">
                    <option value="1">Fruits</option>
                    <option value="2">Vegetables</option>
                    <option value="3">Meat</option>
                    <option value="4">Bakery Items</option>
                    <option value="5">Fish and Seafood</option>
                    <option value="6">Delicatessen</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12"><label class="labels">Product Description*</label><input type="textbox" class="form-control" placeholder="" name="description" id="ptextbox"> </div>

        <div class="col-md-12"><label class="labels">Product Allergy Information</label><input type="textbox" class="form-control" placeholder="" name="allergy" id="ptextbox"> </div>

        <br>
    </div>

    <div class="row mt-2">
        <div class="col-md-6"><label class="labels">Product Minimum Quantity* </label><input type="number" class="form-control" name="minimum" min="1"></div>
        <div class="col-md-6"><label class="labels">Product Maximum Quantity*</label><input type="number" class="form-control" name="maximum" min="1"></div>
    </div>
    <br>
    <div class="col-md-6">
        <label class="labels">Shop*</label>
        <div class="pk-form">
            <select name="shop_option" id="option" class="option pickout" placeholder="Select a Shop">
                <?php

                $user_id = $_SESSION["user_id"];
                $query = "select * from shop where USER_ID =$user_id ";
                $result = oci_parse($connection, $query);
                if (oci_execute($result)) {
                    while (($row = oci_fetch_assoc($result)) != false) {
                        $shop_id = $row["SHOP_ID"];
                        $shop_name = $row["SHOP_NAME"];

                ?>
                        <option value="<?php echo $shop_id; ?>"><?php echo $shop_name; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br><br>
    <div class=" row mt-5">
        <div class="col-md-12" style="margin-top: 10px;"><label class="labels"> Upload an
                Image*</label>
            <br>
            <input type="file" id="myFile" name="file">
        </div>
        <br>

        <div class="mt-4 text-right"><button class="btn btn-dark profile-button" id="tbutton" type="submit" name="add_product">Add
                Product</button></div>
    </div>

    <div class="error_message">
        <?php
        if (isset($_SESSION['feild_empty_error'])) {
            echo $_SESSION['feild_empty_error'];
            unset($_SESSION['feild_empty_error']);
        }
        ?>
    </div>

    <div class="success_message">
        <?php
        if (isset($_SESSION['product_add_message'])) {
            echo $_SESSION['product_add_message'];
            unset($_SESSION['product_add_message']);
        }
        ?>
    </div>

    <style>
        .error_message {
            color: red;
            font-size: 20px;
            text-align: left;
            padding-top: 15px;

        }

        .success_message {
            color: green;
            font-size: 20px;
            text-align: left;
            padding-top: 15px;
        }
    </style>





    </div>
    </div>
</form>

</div>
</div>
<script src="pickout.js"></script>
<script>
    pickout.to({
        el: '.pickout',
        search: true,
        txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
    });
    pickout.updated('.country');
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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