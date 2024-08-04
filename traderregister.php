<?php
include("session.php");
include("customer_header.php");
?>

<!doctype html>
<html lang="en">
<br> <br>

<br> <br>

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

            <p style="font-size:14px; font-family: 'Verdana', sans-serif;">Register as a <a href="#" style="color:darkgreen;"> Trader.</a> </p>

          </div>

          <div class="app-contact">CONTACT INFO : + 12 34 56 78 90</div>
        </div>
        <div class="screen-body-item">
          <form action="trader_validation.php" method="post" onsubmit="return validate()">
            <div class="app-form">
              <div class="app-form-group">
                <input class="app-form-control" placeholder="YOUR NAME" name="fullname" style="text-transform: none;">
              </div>
              <div class="app-form-group">
                <input class="app-form-control" placeholder="EMAIL" name="email" style="text-transform: none;">
                <div class="error_message">
                  <?php
                  if (isset($_SESSION["email_error_message"])) {
                    echo $_SESSION["email_error_message"];
                    unset($_SESSION["email_error_message"]);
                  }

                  ?>
                </div>
                <div class="error_message">
                  <?php
                  if (isset($_SESSION["username_error_message"])) {
                    echo $_SESSION["username_error_message"];
                    unset($_SESSION["username_error_message"]);
                  }
                  ?>
                </div>
              </div>




              <div class="app-form-group">
                <input class="app-form-control" type="password" placeholder="PASSWORD" name="password" id="password">
                <div class="error_message">
                  <?php
                  if (isset($_SESSION["password_error_message"]))
                    echo $_SESSION["password_error_message"];
                  unset($_SESSION["password_error_message"]);
                  ?>
                </div>
              </div>

              <div class="app-form-group">
                <input class="app-form-control" placeholder="CONFIRM PASSWORD" type="password" name="confirm_password" onkeyup="check(this)">
                <error id="alert" class="alert"></error>
              </div>

              <div class="app-form-group">
                <input class="app-form-control" placeholder="CONTACT NUMBER" name="contact">
              </div>

              <div class="app-form-group">
                <label for="birthday" style="font-family:'Verdana'; color:grey; font-size:12px;">BIRTHDAY</label>
                <input class="app-form-control" type="date" id="birthday" name="birthday">
              </div>
              <script>
                birthday.max = new Date().toLocaleDateString('en-ca')
              </script>

              <div class="app-form-group">
                <label for="text-box" style="font-family:'Verdana'; color:grey; font-size:11px;">WHAT DO YOU WANT TO SELL?</label>
                <input class="app-form-control" type="textbox" id="textbox" name="sell-textbox">
              </div>

              <p style="font-size:14px;"> Already have an account? <a href="register.html" style="COLOR:darkgreen;"> Click here</a> </p>
              <div class="error_message">
                <?php
                if (isset($_SESSION["empty_error_message"])) {
                  echo $_SESSION["empty_error_message"];
                  unset($_SESSION["empty_error_message"]);
                }
                ?>
              </div>
              <p align="right">
                <button type="submit" class="btn btn-success" name="traderl">Next</button>

            </div>
            </p>



          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<br>

<br>

<br>

<?php
include("footer.php");
?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<style>
  .error_message {
    color: red;
    font-size: 14px;
    text-align: left;
  }

  .alert {
    color: red;
    font-size: 13px;
    text-align: left;
  }
</style>
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

</body>

</html>