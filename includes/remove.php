<?php
    include_once 'config.php';

    $visitId = $_POST['visit_id'];
    $sql = "DELETE FROM tbl_visits WHERE visit_id = '$visitId'";
    if (mysqli_query($connection, $sql)) {
    } else {
        echo mysqli_error($connection);
    }

?>