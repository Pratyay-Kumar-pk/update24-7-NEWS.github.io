<?php
$msg = "";

include 'config.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            if ($password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password = '{$password}', code='' WHERE code = '{$_GET['reset']}'");

                if ($query) {
                    header("Location: login.php");
                }
            } else {
                $msg = "<div class = 'alert alert-danger'>Password and Confirm password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class = 'alert alert-danger'>Reset link do not match.</div>";
    }
} else {
    header("Location : forgot-password.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css" type="text/css" media="all" />
    <link rel="shortcut icon" type="x-icon" href="assets/reset-password.png">
    <title>Change Password</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" method="post">
                    <h2 class="title">Change Password</h2>
                    <?php echo $msg; ?>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required />
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
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your confirm  Password" style="margin-bottom: 2px;" required />
                        <i class="uil uil-eye icon" id="toggleConfirmPassword"></i>
                    </div>
                    <input name="submit" type="submit" value="Change Password" class="btn solid change-password-btn" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>CHANGE YOUR PASSWORD</h3>
                </div>
                <img src="images/forgot-password.svg" class="image" alt="" />
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