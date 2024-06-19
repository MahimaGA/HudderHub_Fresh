<?php
include('admin_header.php')
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="./style.css">

<body>
    <br><br><br>
    <div class="screen-body">
        <div class="screen-body-item left">
            <div class="app-title">
                <span>ADMIN REGISTRATION</span>
            </div><br><br>
            <form action="admin_registration.php" method="post" onsubmit="return validateForm()">
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

                    <input type="submit" name="admin_registration" value="SUBMIT">
                </div>

                <div class="error_message" id="empty_error_message"></div>

            </form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>