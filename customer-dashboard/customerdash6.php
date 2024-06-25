<?php
include('cust_dash_header.php')
?>
<!doctype html>
<html lang="en">
</body>



<h2 class="trader-profile">Reset Password</h2>
<img src="../trader-dashboard/images/reset_password.svg" alt="">
<p class="resetpw"> Please create a new password that you don’t use on any other site. </p>

<form action="reset_password.php" method="post" onsubmit="return validate()">
    <div class="row mt-3">

    </div>

    <div class="row mt-3">
        <div class="col-md-6"><input type="password" class="form-control" placeholder="Current Password" name="current">
        </div>
        <br>

    </div>
    <div class="error_message">
        <?php
        if (isset($_SESSION['empty_currentp'])) {
            echo $_SESSION['empty_currentp'];
            unset($_SESSION['empty_currentp']);
        }
        ?>
    </div>

    <div class="row mt-3">
        <div class="col-md-6"><input type="password" class="form-control" placeholder="New Password" id="password" name="new">
        </div>
        <br>


    </div>
    <div class="error_message">
        <?php
        if (isset($_SESSION['empty_newp'])) {
            echo $_SESSION['empty_newp'];
            unset($_SESSION['empty_newp']);
        }
        ?>
    </div>

    <div class="error_message">
        <?php
        if (isset($_SESSION['password_error_message'])) {
            echo $_SESSION['password_error_message'];
            unset($_SESSION['password_error_message']);
        }
        ?>
    </div>



    <div class="row mt-3">

        <div class="col-md-6"><input type="password" class="form-control" name="recent" placeholder="Confirm Password" onkeyup="check(this)">
            <div id="alert" class="alert"></div>
        </div>
    </div>
    <div class="error_message">
        <?php
        if (isset($_SESSION['empty_recentp'])) {
            echo $_SESSION['empty_recentp'];
            unset($_SESSION['empty_recentp']);
        }
        ?>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">

            <div class="resetpw2">

                Password must:
                Be between 9 and 64 characters

                Include at least two of the following:
                <ul>
                    <li> An uppercase character </li>
                    <li> A lowercase character </li>
                    <li> A number </li>
                    <li> A special character</li>

                </ul>
            </div>
        </div>
    </div>



    <div class="mt-4 text-left"><button class="btn btn-dark profile-button" id="tbutton" name="reset" type="submit">Reset
            Password</button></div>
    <div class="success_message">
        <?php
        if (isset($_SESSION['reset_message'])) {
            echo $_SESSION['reset_message'];
            unset($_SESSION['reset_message']);
        }
        ?>
    </div>
    </div>

    <style>
        .error_message {
            color: red;
            font-size: 14px;
            text-align: left;
        }

        .success_message {
            color: green;
            font-size: 20px;
            text-align: left;
        }
    </style>
    </div>
</form>
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
    var password = document.getElementById('password');
    flag = 1;

    function check(elem) {
        if (elem.value.length > 0) {
            if (elem.value != password.value) {
                document.getElementById('alert').innerText = "Confirm password does not match.";
                flag = 0;
            } else {
                document.getElementById('alert').innerText = "";
                flag = 1;
            }
        } else {
            document.getElementById('alert').innerText = "Please enter confirm password.";
            flag = 0;
        }
    }


    function validate() {
        if (flag == 1) {
            return true;
        } else {
            return false;
        }
    }
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