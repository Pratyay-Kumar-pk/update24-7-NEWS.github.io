<?php
session_start();
session_unset();
session_destroy();
echo "Redirecting to index.php"; // Debugging statement
header("Location: index.php");
exit();
