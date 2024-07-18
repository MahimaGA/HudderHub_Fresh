<!doctype html>
<html lang="en">
<body>
    <?php
      include("customer_header.php");
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
            <span >WELCOME BACK,</span>
            <span>PLEASE LOGIN</span>
          <span style="font-weight: 300;">to your account.</span>
          </div>
        </div>
        <div class="screen-body-item">
          <form action="login_verification.php" method ="post">
          <div class="app-form">
            <div class="app-form-group">
              <input class="app-form-control" type="email" placeholder="Email" name ="username">
            </div>
            
            <div class="app-form-group">
              <input class="app-form-control" type="password" placeholder="Password" name="password">
            </div>
           
            <br>


            <p style="font-size:14px;"> NEED AN ACCOUNT? <a href="newregister.php" style="COLOR:darkgreen;"> SIGN UP</a> </p>
        
             <input type="submit" name="login"> 
          </div>
          <div class="error_message">
            <?php 
              if(isset($_SESSION["feild_empty_message"]))
              {
                echo $_SESSION["feild_empty_message"];
                unset($_SESSION["feild_empty_message"]);
              }
              
              ?>
            </div>
            </div>

          <div class="error_message">
            <?php 
              if(isset($_SESSION["not_active_error_message"]))
              {
                echo $_SESSION["not_active_error_message"];
                unset($_SESSION["not_active_error_message"]);
              }
              
              ?>
            </div>

            <div class="error_message">
            <?php 
              if(isset($_SESSION["invalid_credential_error_message"]))
              {
                echo $_SESSION["invalid_credential_error_message"];
                unset($_SESSION["invalid_credential_error_message"]);
              }
              
              ?>
            </div>

            <div class="success_message">
            <?php 
              if(isset($_SESSION["trader_mail_sent_message"]))
              {
                echo $_SESSION["trader_mail_sent_message"];
                unset($_SESSION["trader_mail_sent_message"]);
              }
              
              ?>
            </div>

            <div class="success_message">
            <?php 
              if(isset($_SESSION["trader_approval_message"]))
              {
                echo $_SESSION["trader_approval_message"];
                unset($_SESSION["trader_approval_message"]);
              }
              
              ?>
            </div>
            
            
            <div class="success_message">
            <?php 
              if(isset($_SESSION["approved_confirm_message"]))
              {
                echo $_SESSION["approved_confirm_message"];
                unset($_SESSION["approved_confirm_message"]);
              }
              ?>
            </div>
            
            <div class="success_message">
            <?php 
              if(isset($_SESSION["mail_sent_message"]))
              {
                echo $_SESSION["mail_sent_message"];
                unset($_SESSION["mail_sent_message"]);
              }
              ?>
            </div>
            
            
        </div>
        </form>
      </div>
    </div>

  </div>
</div>


<br>

<br>

<br>

<!-- Footer -->
<?php
include("footer.php");
?>

<style>
.error_message{
  color:red;
  font-size: 15px;
  text-align: left;
  font-family: 'Lato', sans-serif;
}

.success_message{
  color:green;
  font-size: 15px;
  text-align: left;
  font-family: 'Lato', sans-serif;
}

.contactus {
    display: flex;
  /*  min-height: 30vh;
    margin-bottom: 50px;*/
  }
  
  .container {
    flex: 0 1 800px;
  
  }
  
  .screen {
    position: relative;
    background: #F2F2F0;
    border-radius: 15px;
  }
  
  .screen:after {
    content: '';
    display: block;
    position: absolute;
    top: 0;
    left: 20px;
    right: 20px;
    bottom: 0;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, .4);
    z-index: -1;
    background: #F2F2F0; 
}

  
  .screen-header {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background: #C0D8C0;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
  }
  
  .screen-header-left {
    margin-right: auto;
  }
  
  .screen-header-button {
    display: inline-block;
    width: 8px;
    height: 8px;
    margin-right: 3px;
    border-radius: 8px;
    background: white;
  }
  
  .screen-header-button.close {
    background: #ed1c6f;
  }
  
  .screen-header-button.maximize {
    background: #e8e925;
  }
  
  .screen-header-button.minimize {
    background: #74c54f;
  }
  
  .screen-header-right {
    display: flex;
  }
  
  .screen-header-ellipsis {
    width: 3px;
    height: 3px;
    margin-left: 2px;
    border-radius: 8px;
    background: #999;
  }
  
  .screen-body {
    display: flex;
  }
  
  .screen-body-item {
    flex: 1;
    padding: 40px;
  
  }x
  
  .screen-body-item.left {
    display: flex;
    flex-direction: column;
  }
  
  .app-title {
    display: flex;
    flex-direction: column;
    position: relative;
    color: darkgreen;
    font-size: 26px;
  }
  
  .app-title:after {
    content: '';
    display: block;
    position: absolute;
    left: 0;
    bottom: -10px;
    width: 25px;
    height: 4px;
    background: darkgreen;
  }
  
  .app-contact {
    margin-top: auto;
    font-size: 8px;
    color: #888;
  }
  
  .app-form-group {
    margin-bottom: 15px;
  color:  darkgreen;
  }
  
  .app-form-group.message {
    margin-top: 40px;
  }
  
  .app-form-group.buttons {
    margin-bottom: 0;
    text-align: right;
  }
  
  .app-form-control {
    width: 100%;
    padding: 10px 0;
    background: none;
    border: none;
    border-bottom: 1px solid #666;
    color: darkgreen;
    font-size: 12px;
    text-transform: none; /* Prevent automatic conversion to uppercase */
    outline: none;
    transition: border-color .2s;
    font-family: 'Lato', sans-serif;
  
  }
  
  .app-form-control::placeholder {
    color: #666;
  }
  
  .app-form-control:focus {
    border-bottom-color: #ddd;
  }
  
  .app-form-button {
    background: none;
    border: none;
    color: darkgreen;
    font-size: 14px;
    cursor: pointer;
    outline: none;
    font-family: 'Lato', sans-serif;
  }
  
  .app-form-button:hover {
    color: black;
  }
  
  
  @media screen and (max-width: 520px) {
    .screen-body {
      flex-direction: column;
    }
  
    .screen-body-item.left {
      margin-bottom: 30px;
    }
  
    .app-title {
      flex-direction: row;
    }
  
    .app-title span {
      margin-right: 12px;
    }
  
    .app-title:after {
      display: none;
    }
  }
  
  @media screen and (max-width: 600px) {
    .screen-body {
      padding: 40px;
    }
  
    .screen-body-item {
      padding: 0;
    }
  }
  .call-icon{
  
  
    margin-top: 50px;
  }
  
  
  
  
  /*side by category*/
  
  .category-product{
    margin-top: 40px;
  }
  
  
  .list-group, .list-group-item{
  
    font-family: 'Lato', sans-serif;
    font-size: 16px;
  
  
  }
  
  p {
      font-family: 'Poppins', sans-serif;
      font-size: 1.3em;
      font-weight: 300;
      line-height: 1.7em;
      color: #999;
  }
  
  .reg-check{
  
        font-family: 'Poppins', sans-serif;
  
  }
  
  
  .cat-head{
  
    color: #4C4E52;
    margin-left: 30px;
  }
  
  a,
  a:hover,
  a:focus {
      color: black;
      text-decoration: none;
      transition: all 0.3s;
  }
  
  .navbar {
      padding: 15px 10px;
      background: #fff;
      border: none;
      border-radius: 0;
      margin-bottom: 40px;
      box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
      font-family: 'Lato', sans-serif;
  }
  
  .navbar-btn {
      box-shadow: none;
      outline: none !important;
      border: none;
  }
  
  .line {
      width: 100%;
      height: 1px;
      border-bottom: 1px dashed #ddd;
      margin: 40px 0;
  }


</style>

</body>

</html>
