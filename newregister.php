<?php
include("session.php");
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="./stylesheet/style4.css">

<body>

    <?php
    include("customer_header.php");
    ?>
    <br><br><br><br>
    <div class="contactus">
        <div class="container">
            <div class="screen">
                <div class="screen-header">

                </div>
                <div class="screen-body">
                    <div class="screen-body-item left">
                        <div class="app-title">
                            <span>CREATE</span>
                            your account.

                        </div>
                        <br>
                        <br>
                        <div class="column-cs">
                            <img src="images/cicon2.png" class="cicon1">
                            <p style="font-size:14px; font-family: 'Verdana', sans-serif; color:'darkgrey;'"> Register as a <a href="newregister.php" style="color:darkgreen;"> Customer.</a> </p>

                        </div>
                        <br>

                        <div class="column-cs">
                            <img src="images/cicon3.png" class="cicon2">

                            <p style="font-size:14px; font-family: 'Verdana', sans-serif;">Register as a <a href="traderregister.php" style="color:darkgreen;"> Trader.</a> </p>

                        </div>


                        <div class="app-contact">CONTACT INFO : + 12 34 56 78 90</div>
                    </div>
                    <div class="screen-body-item">
                        <form action="user_registration.php" method="post" onsubmit="return validateForm()">
                            <div class="app-form">
                                <div class="app-form-group">
                                    <input class="app-form-control" placeholder="YOUR NAME" name="fullname" required>
                                </div>
                                <div class="app-form-group">
                                    <input class="app-form-control" placeholder="EMAIL" name="email" type="email" required>
                                </div>

                                <div class="error_message" id="email_error_message"></div>

                                <div class="app-form-group">
                                    <input class="app-form-control" type="password" placeholder="PASSWORD" name="password" id="password" required>
                                </div>

                                <div class="error_message" id="password_error_message"></div>

                                <div class="app-form-group">
                                    <input class="app-form-control" type="password" placeholder="CONFIRM PASSWORD" name="c_password" id="c_password" onkeyup="check(this)" required>
                                    <error id="alert" class="alert"></error>
                                </div>

                                <div class="app-form-group">
                                    <input class="app-form-control" placeholder="CONTACT NUMBER" name="contact" required>
                                </div>


                                <div class="app-form-group">
                                    <label for="birthday" style="font-family:'Verdana'; color:grey; font-size:12px;">BIRTHDAY</label>
                                    <input class="app-form-control" type="date" id="birthday" name="birthday" required>
                                </div>
                                <script>
                                    birthday.max = new Date().toLocaleDateString('en-ca')
                                </script>

                                <input type="checkbox" id="terms" name="terms" value="terms" required> <label for="terms" style="font-family:'Verdana', sans-serif; font-size: 9px;"> Do you agree to all the terms? </label>

                                <br>
                                <p style="font-size:14px;"> Already have an account? <a href="login.php" style="COLOR:darkgreen;"> Click here</a> </p>

                                <input type="submit" name="user_registration" value="SUBMIT">
                            </div>

                            <div class="error_message" id="empty_error_message"></div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <br><br><br>

    <?php
    include("footer.php");
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
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
</html>