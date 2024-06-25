<?php
include('session.php');
include('../functions.php');

if (isset($_POST['reset'])) {
    if (!empty($_POST['current'])) {
        if (!empty($_POST['new'])) {
            if (!empty($_POST['recent'])) {
                $cpassword = $_POST['current'];
                $current_password = md5($cpassword);
                if ($current_password == $_SESSION["user_password"]) {
                    $recent_password = $_POST['recent'];
                    if ($recent_password != $cpassword) {
                        $r_password = reset_password_validation($recent_password); {
                            if (!empty($r_password)) {
                                $r_password = md5($r_password);
                                $user_id = $_SESSION["user_id"];
                                $resetquery = "update hhf_user set user_password ='$r_password' where USER_ID =$user_id";
                                $stid = oci_parse($connection, $resetquery);

                                if (oci_execute($stid)) {
                                    unset($_SESSION["password"]);
                                    $_SESSION["password"] = $r_password;
                                    $to = $_SESSION["email"];
                                    $name = $_SESSION['name'];
                                    $subject = "Reset successfully";
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
                                                            Welcome
                                                            <div class='name'>
                                                                <span style='font-size: 20px;'>$name</span>

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
                                                            Your password has been changed successfully. 
                                                            </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor='#ffffff' align='left'>
                                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                            <tr>
                                                                <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 30px 30px;'>
                                                                    <table border='0' cellspacing='0' cellpadding='0'>
                                                                        <tr>
                                                                

                                                                        <span> Password has been reset successfully.</span>

                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td bgcolor='#ffffff' align='center'>
                                                        <p class='start-text'
                                                            style='font-family: 'Josefin Sans'; font-size: 17px;'  align='center'>

                                                            HudderHub Fresh lets you shop at various stores in your local area of Cleckhudderfaux. HudderHub Fresh focuses on delivering quality, fresh, organic food with a short supply chain, working directly with its local farms, dairies, fisheries, and other food partners. 
                                                            


                                                            </p>                   
                            <br>
                                                        <p class='start-text' style='font-family: 'Josefin Sans'; margin-left: 60px; align='center'>
                                                            If you have any questions, just reply to hudderhubfresh@gmail.com, we're always happy
                                                                to help out.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor='#ffffff' align='left' margin-left: 40px; margin-right: 40px; >

                                                        <p class='start-text'
                                                            style='font-family: 'Josefin Sans'; margin-left: 40px; margin-right: 40px; font-size: 17px;'>
                                                            Cheers, <br> HudderHub Fresh Team</p>

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
                                        $_SESSION["reset_message"] = "Your password has been reset successfully.";
                                        header('location: customerdash6.php');
                                    }
                                }
                            }
                        }
                    } else {
                        $_SESSION['empty_newp'] = "Please try new password.";
                        header('location: customerdash6.php');
                    }
                } else {
                    $_SESSION['empty_currentp'] = "Invalid current password.";
                    header('location: customerdash6.php');
                }
            } else {
                $_SESSION['empty_recentp'] = "Enter confirm password";
                header('location: customerdash6.php');
            }
        } else {
            $_SESSION['empty_newp'] = "Enter new password";
            header('location: customerdash6.php');
        }
    } else {
        $_SESSION['empty_currentp'] = "Enter current password";
        header('location: customerdash6.php');
    }
}
?>