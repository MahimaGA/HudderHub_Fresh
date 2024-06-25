<?php
include('cust_dash_header.php');
?>
<!doctype html>
<html lang="en">
<?php
$username = $_SESSION["username"];
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$contact = $_SESSION["contact"];
$birthdate = $_SESSION["birthdate"];
$user_image = $_SESSION["user_image"];
$user_id = $_SESSION["user_id"];
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<body>
    <form action="upload_image.php" method="post" enctype="multipart/form-data">
        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <div class="ppimage">
                    <div class="control-group file-upload" id="file-upload1">
                        <div class="image-box text-center ">
                            <img src="images/<?php echo $user_image; ?>" alt="" class="imgupload">
                        </div>
                        <br>
                        <button type="submit" name="upload_image" class="text-center" id="text1" style="color: black;"> Upload Image </button>
                        <div class="controls" style="display: none;">
                            <input type="file" name="file" />
                        </div>
                    </div>
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
                    if (isset($_SESSION['image_error'])) {
                        echo $_SESSION['image_error'];
                        unset($_SESSION['image_error']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
    <style>
        .error_message {
            color: red;
            font-size: 16px;
            align: left;
        }
    </style>

    <br> <br>
    <div class="row mt-2">
        <div class="col-md-12 text-center"><label class="labels3"><strong></strong> </label>
            <img src="images/<?php echo $user_image; ?>" alt="Profile Picture" class="imgupload rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-center"><label class="labels3"><strong>Name: </strong> </label>
                <span class="labels2"> <?php echo $name; ?> <img src="images/verified.png" alt="" srcset="" style="margin-bottom:5px;">
                </span>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-12 text-center"><label class="labels3"><strong>Email Address: </strong> </label>
                <span class="labels2"> <?php echo $email; ?></span>
            </div>

            <div class="col-md-12 text-center" style="margin-top: 10px;"><label class="labels3"><strong> Mobile Number: </strong> </label>
                <span class="labels2"><?php echo $contact; ?></span>
            </div>


            <div class="col-md-12 text-center" style="margin-top: 10px;"><label class="labels3"><strong>Birthday: </strong> </label>
                <span class="labels2"> <?php echo $birthdate; ?></span>

            </div>
            <div class="col-md-12 text-center" style="margin-top: 10px;">
                <a href="customerdash5.php"><button class="btn btn-dark profile-button" id="tbutton" type="button">Update
                        Profile</button></a>
            </div>

            <br>

        </div>

        <br>
        <br>


        <div class="row mt-2">
            <div class="col-md-12">

                <img src="images/custbanner.jpg" alt="" srcset="" class="img-responsive center-block d-block mx-auto" style="border-radius: 20px; max-width: 1000px;">

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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