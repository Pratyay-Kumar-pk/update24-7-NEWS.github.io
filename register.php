<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}','{$email}','{$password}','{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div style='display:none;'>";
                // Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'updates24x7.news@gmail.com';                     // SMTP username
                    $mail->Password   = 'jqjvkrtileccnfqy';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                    $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    // Recipients
                    $mail->setFrom('updates24x7.news@gmail.com', 'No Reply');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'No reply';
                    $mail->Body    = 'Here is the verification link <b><a href="http://localhost/news/?verification=' . $code . '">http://localhost/news/?verification=' . $code . '</a></b>';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>We've sent a verification link to your email address</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and confirm password do not match</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="shortcut icon" type="x-icon" href="assets/register.png">
    <title>Register</title>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-up-form" method="post">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" class="name" name="name" placeholder="Username" value="<?php if (isset($_POST['submit'])) {
                                                                                                        echo $name;
                                                                                                    } ?>" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="email" name="email" placeholder="Email" value="<?php if (isset($_POST['submit'])) {
                                                                                                        echo $email;
                                                                                                    } ?>" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="password" name="password" placeholder="Password" required />
                        <i class="uil uil-eye icon" id="togglePassword"></i>
                        <div class="password-strength">
                            <span class="strength-bar"></span>
                            <span class="strength-bar"></span>
                            <span class="strength-bar"></span>
                            <span class="strength-bar"></span>
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm Password" required />
                        <i class="uil uil-eye icon" id="toggleConfirmPassword"></i>
                    </div>
                    <input name="submit" type="submit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>IF YOU ALREADY HAVE AN ACCOUNT</h3>
                    <button class="btn transparent" id="sign-in-btn">
                        <a href="login.php">Sign in</a>
                    </button>
                </div>
                <img src="images/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
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