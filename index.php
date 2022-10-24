<?php
    // Makes database connection.
    include_once 'includes/config.php';

    if (isset($_SESSION['userId'])) {
        header('Refresh:0; url=home.php');
    } else {
        header('Refresh:0; url=login.php');
    }
?>