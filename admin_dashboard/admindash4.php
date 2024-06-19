<?php
include('session.php');
include('admin_header.php');
include('connection.php');
$user_id = $_SESSION["user_id"];
$query = "select * from HHF_USER where USER_ID = $user_id";
$result = oci_parse($connection, $query);
if (oci_execute($result)) {
    while (($row = oci_fetch_assoc($result)) != false) {

        $user_role = $row["USER_ROLE"];
        $status = $row["STATUS"];
        $name = $row["FULL_NAME"];
        $user_id = $row["USER_ID"];
        $gmail = $row["EMAIL"];
        $contact = $row["CONTACT_NO"];
        $birthdate = $row["DATE_OF_BIRTH"];
        $birthdate_formatted = date('Y-m-d', strtotime($birthdate));
    }
}
if (isset($_GET["itisme"])) {
    $decision = $_GET["itisme"];

    if ($decision == "YES") {
        $name = $_SESSION["c_name"];
        $contact = $_SESSION["c_contact"];
        $birth_date = $_SESSION["c_date"];

        $user_id = $_SESSION["user_id"];
        $format = 'DD-MM-YY';
        $query = "update HHF_USER set FULL_NAME ='$name', CONTACT ='$contact', DATE_OF_BIRTH =to_date('.$birth_date.','.$format.') where USER_ID =$user_id ";
        $result = oci_parse($connection, $query);
        if (oci_execute($result)) {
            unset($_SESSION["c_contact"]);
            unset($_SESSION["c_name"]);
            unset($_SESSION["c_date"]);
            $_SESSION["email"] = $gmail;
            $_SESSION["name"] = $name;
            $_SESSION["contact"] = $contact;
            $_SESSION["birthdate"] = $birthdate_formatted;

            $_SESSION['update_message'] = "Profile updated Successfully.";
        }
    } else {
        $_SESSION['update_message'] = "Profile updation failed.";
    }
}
?>
<!doctype html>
<html lang="en">
</body>

<h2 class="trader-profile">Account Setting</h2>

<form action="update_account.php" method="post">
    <div class="row mt-2">
        <div class="col-md-6"><label class="labels">Name </label><input type="text" class="form-control" value="<?php echo $name; ?>" name="name"></div>

    </div>

    <div class="col-md-12" style="margin-top: 10px;"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="Mobile Number" name="number" value="<?php echo $contact; ?>"></div>

    <div class="col-md-12" style="margin-top: 10px;">
            <label class="labels">Birthday</label>
            <input type="date" class="form-control" id="birthday" name="date" value="<?php echo $birthdate_formatted; ?>">
        </div>

    <script>
        birthday.max = new Date().toLocaleDateString('en-ca')
    </script>
    <br>
    <div class="mt-4 text-right"><button class="btn btn-dark profile-button" id="tbutton" type="submit" name="update_profile">Save
            Profile</button></div>
    </div>
</form>



<div class="error_message">
    <?php
    if (isset($_SESSION['empty_field'])) {
        echo $_SESSION['empty_field'];
        unset($_SESSION['empty_field']);
    }
    ?>
</div>
<div class="error_message">
    <?php

    if (isset($_SESSION['email_error_message'])) {
        echo $_SESSION['email_error_message'];
        unset($_SESSION['email_error_message']);
    }
    ?>
</div>

<div class="success_message">
    <?php
    if (isset($_SESSION['update_message'])) {
        echo $_SESSION['update_message'];
        unset($_SESSION['update_message']);
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