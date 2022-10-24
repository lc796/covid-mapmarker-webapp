<?php
  // Start session
  session_start();
  // Unset userId SESSION variable
  unset($_SESSION["userId"]);
  // Destroy session
  session_destroy();
  // Redirect user to index.php
  header("Location:index.php");
?>