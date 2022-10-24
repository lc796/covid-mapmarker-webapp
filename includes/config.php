<?php
// Server IP
$dbServer = "localhost";
// MYSQL User
$dbUser = "root";
// MYSQL Password
$dbPassword = "";
// MYSQL Database Name, requires prior creation to form connection
$dbName = "webdev";

// Connection stored in variable called connection
$connection = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);
?>