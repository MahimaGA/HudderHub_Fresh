<?php
include('session.php');
?>

<!doctype html>
<html lang="en">

<?php
include('customer_header.php');
?>
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
                <input class="app-form-control" placeholder="SHOP NAME" name="shop_name" style="text-transform: none;">
                <div class="error_message">
                  <?php
                  if (isset($_SESSION["shopname_error_message"]))
                    echo $_SESSION["shopname_error_message"];
                  unset($_SESSION["shopname_error_message"]);
                  ?>
                </div>
              </div>



              <div class="app-form-group">
                <input class="app-form-control" placeholder="SHOP LOCATION" name="location" style="text-transform: none;">
              </div>

              <div class="app-form-group">
                <input class="app-form-control" placeholder="SHOP REGISTRATION NUMBER" name="pan" type="number" min="1">
                <div class="error_message">
                  <?php
                  if (isset($_SESSION["pan_error_message"]))
                    echo $_SESSION["pan_error_message"];
                  unset($_SESSION["pan_error_message"]);
                  ?>
                </div>
              </div>



              <div class="app-form-group">
                <label for="text-box" style="font-family:'Verdana'; color:grey; font-size:12px;">TELL US WHAT MAKES YOUR SHOP UNIQUE AND SPECICAL.</label>
                <input class="app-form-control" type="textbox" id="textbox" name="sell-point">
              </div>

              <input type="checkbox" id="terms" name="terms" value="terms"> <label for="terms" style="font-family:'Verdana', sans-serif; font-size: 9px; color:black;"> Do you agree to all the terms? </label>

              <br>

              <br>
              <div class="error_message">
                <?php
                if (isset($_SESSION['empty_error_message']))
                  echo $_SESSION['empty_error_message'];
                unset($_SESSION['empty_error_message']);
                ?>
              </div>
              <p align="right">
                <button type="submit" class="btn btn-success" name="trader2">Submit</button>
              </p>

            </div>



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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<style>
  .error_message {
    color: red;
    font-size: 14px;
    text-align: left;
  }
</style>

<script>
  function validate() {

    if (document.getElementById('terms').checked) {
      flag = 1;
    } else {
      alert("Please check terms and conditions before submission.");
      flag = 0;
    }


    if (flag == 1) {
      return true;
    } else {
      return false;
    }
  }
</script>
</body>

</html>