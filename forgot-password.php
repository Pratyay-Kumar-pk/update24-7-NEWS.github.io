<?php

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {
            echo "<div style = 'display:none;'>";
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'updates24x7.news@gmail.com';                     //SMTP username
                $mail->Password   = 'jqjvkrtileccnfqy';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('updates24x7.news@gmail.com',);
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the reset password link <b><a href ="http://localhost/news/change-password.php?reset=' . $code . '">http://localhost/news/change-password.php?reset=' . $code . '</a></b>';


                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";
            $msg = "<div class = 'alert alert-info'>We've send a verification link to your email address</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address is not registered.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css" />
    <link rel="shortcut icon" type="x-icon" href="assets/forgot-password.png">
    <title>Forgot password</title>
</head>

<body>

    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="" class="sign-in-form" method="post">
                        <h2 class="title">Forgot Password</h2>
                        <?php echo $msg; ?>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required />
                        </div>
                        <input name="submit" type="submit" value="send reset link" class="btn solid" />
                        <a class="reset-link-btn" href="login.php">
                            <p>Click here to go back to login page</p>
                        </a>
                    </form>
                </div>
            </div>
            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>DID YOU FORGET YOUR PASSWORD?DON NOT WORRY RESET YOUR PASSWORD BY GIVING YOUR REGISTERED EMAIL</h3>
                    </div>
                    <img src="images/forgot-password.svg" class="image" alt="" />
                </div>
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <script>
            $(document).ready(function(c) {
                $('.alert-close').on('click', function(c) {
                    $('.main-mockup').fadeOut('slow', function(c) {
                        $('.main-mockup').remove();
                    });
                });
            });
        </script>

    </body>

</html>