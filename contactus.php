<!doctype html>
<html lang="en">
<?php
include('customer_header.php');
if (isset($_POST["send"])) {
  if (
    !empty($_POST["name"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["contact"]) &&
    !empty($_POST["message"])
  ) {
    $name = $_POST["name"];
    $contact = $_POST["contact"];
    $message = $_POST["message"];

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $email = $_POST["email"];

      $to = "hudderhubfresh@gmail.com";
      $subject = "Message From A Customer";
      $message = "
        <!DOCTYPE html>
        <html>

        <head>
            <title></title>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge' />


            <head>
                <link rel='stylesheet' href='emailstyle.css'>

                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css'
                    integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>


                <link rel='preconnect' href='https://fonts.googleapis.com'>
                <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                <link
                    href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap'
                    rel='stylesheet'>
                <link
                    href='https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300&family=Merriweather&family=Montserrat:wght@200;400&family=Poppins:wght@200&family=Sacramento&display=swap'
                    rel='stylesheet'>
            </head>

        <body>
            <!-- START OF EMAIL TEMP -->
            <div
                style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Josefin Sans', sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>
            </div>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>

                <tr>
                    <td bgcolor='#b8d6ce' align='center'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                            <tr>
                                <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
        <tr>
                    <td bgcolor='#b8d6ce' align='center' style='padding: 0px 10px 0px 10px;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                            <tr>
                                <td bgcolor='#ffffff' align='center' valign='top'
                                    style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                                    <h1
                                        style='font-size: 35px;  margin: 2; font-family: 'Josefin Sans', sans-serif;'>
                                        WELCOME
                                        <div class='name'>
                                            <span style='font-size: 20px;'>Admin</span>

                                        </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                            <tr>
                                <td bgcolor='#ffffff' align='center'>
                                    <p class='start-text'
                                        style='font-family: 'Josefin Sans'; font-size: 17px;'>
                                        Message from a curious customer : </p>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor='#ffffff' align='left'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                                <table border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                            

                                                      <span> Name : $name</span><br>
                                                      <span> Contact : $contact</span><br>
                                                      <span> Email Address : $email</span><br><br><br>
                                                      <span> Message:<br> <strong>$message</strong></span><br>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td bgcolor='#ffffff' align='center'>                    
        <br>
                                    
                                </td>
                            </tr>
                           
                        </table>
                    </td>
                </tr>

            </table>
        </body>
        </html>
        ";
      $eol = PHP_EOL;

      $header = "MIME-Version: 1.0" . $eol;
      $header .= "Content-type:text/html;charset=UTF-8" . $eol;
      $header .= "From: hudderhubfresh@gmail.com" . $eol;
      $header .= "Reply-To: hudderhubfresh@gmail.com" . $eol;


      $mail_sent = mail($to, $subject, $message, $header);
      if ($mail_sent == true) {
        $_SESSION["mail_sent_message"] = "We Received your message.";
        if (isset($_SESSION["mail_sent_message"])) {
          echo '<div class="success">' . $_SESSION["mail_sent_message"] . '</div>';
          unset($_SESSION["mail_sent_message"]);
      }
?>
        <script>
          windows.location.href = windows.location.href;
        </script>
      <?php

      }
    } else {
      $_SESSION["error"] = "Invalid email address.";
      ?>

      <script>
        windows.location.href = windows.location.href;
      </script>
    <?php

    }
  } else {
    $_SESSION["error"] = "All Field are required.";
    ?>

    <script>
      windows.location.href = windows.location.href;
    </script>
<?php
  }
}
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
            <span>CONTACT</span>
            <span>US</span>
          </div>

        </div>
        <form id="form" action="contactus.php" method="POST">
          <div class="screen-body-item">
            <div class="app-form">
              <div class="app-form-group">
                <input class="app-form-control" placeholder="NAME" name="name" id="name">

              </div>
              <div class="app-form-group">
                <input class="app-form-control" placeholder="EMAIL" name="email" id="email">
                <div class="error">
                  <?php
                  if (isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                  }
                  ?>
                </div>
              </div>
              <div class="app-form-group">
                <input class="app-form-control" placeholder="CONTACT NO" name="contact" id="contact">
                <div class="error" id="errorc"></div>
              </div>
              <div class="app-form-group message">
                <input class="app-form-control" placeholder="MESSAGE" name="message" id="message">
                <div class="error" id="errorm"></div>
              </div>
              <div class="app-form-group buttons">
                <button class="app-form-button" type="reset">CANCEL</button>
                <button class="app-form-button" type="submit" name="send">SEND</button>
              </div>
              <div class="error">
                <?php
                if (isset($_SESSION["error"])) {
                  echo $_SESSION["error"];
                  unset($_SESSION["error"]);
                } 
                ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>


<style>
  .error {
    color: red;
    font-size: 13px;
    text-align: left;
  }

  .success {
    color: Green;
    font-size: 20px;
    text-align: center;
    ;
  }
</style>
<br>

<br>



<br>

<br>



<div class="container">



  <div class="row" style="margin-left:20px; margin-right:20px;">


    <div class="col-md-6">


      <div class="aboutus-sec-row">
        <img src="images/phoneui.jpg" class="img-fluid" alt="phone-mockup" style="max-width: 400px; max-height:600px;">
      </div>
    </div>
    <div class="col-md-6">
      <div class="mapouter">
        <div class="gmap_canvas"><iframe width="700" height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=West%20Yorkshire,%20United%20Kingdom%20&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2piratebay.org"></a><br>
          <style>
            .mapouter {
              position: relative;
              text-align: right;
              height: 500px;
              width: 312px;
            }
          </style><a href="https://www.embedgooglemap.net">google maps</a>
          <style>
            .gmap_canvas {
              overflow: hidden;
              background: none !important;
              height: 666px;
              width: 412px;
            }
          </style>
        </div>
      </div>
    </div>
  </div>



  <?php
  include('footer.php');
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  </body>
</html>