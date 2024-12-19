<?php
session_start();
session_destroy(); // Destroy session data
header('Location: index.php');  // Redirect to login page
exit();
?>
