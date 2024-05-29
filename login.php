<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';
$msg = "";

if (isset($_GET['verification'])) {
    $verification_code = mysqli_real_escape_string($conn, $_GET['verification']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE code = '$verification_code'");
    if (mysqli_num_rows($result) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code = '' WHERE code='$verification_code'");
        if ($query) {
            $msg = "<div class='alert alert-success'>Account verified successfully.</div>";
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (empty($row['code'])) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['SESSION_EMAIL'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $msg = "<div class='alert alert-info'>Please verify your account and try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
    }
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
    <link rel="shortcut icon" type="x-icon" href="assets/login.png">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" method="post">
                    <h2 class="title">Sign in</h2>
                    <?php echo $msg; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" class="email" name="email" placeholder="Enter Your Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" required />
                        <i class="uil uil-eye icon" id="togglePassword"></i>
                        <a href="forgot-password.php" class="forgot-password">
                            <p>Forgot password?</p>
                        </a>
                    </div>
                    <input name="submit" type="submit" value="Login" class="btn solid login-btn" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>DO NOT HAVE ANY ACCOUNT? CREATE A NEW ONE</h3>
                    <button class="btn transparent" id="sign-up-btn">
                        <a href="register.php">Sign Up</a>
                    </button>
                </div>
                <img src="images/login.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>