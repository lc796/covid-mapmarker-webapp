<?php
    // Start session
    session_start();

    // Define 'errors' associative array, where a string will be associated with the 'username' error or 'password' error.
    $errors = array('date' => '', 'time' => '');

    // Define 'success' variable as an integer (0 = unassigned, 1 = successful)
    $success = 0;

    // Define 'username' and 'password' variables. Initialise as empty strings.
    $date = "";
    $time = "";

    // When login.php is called (either through clicking button on form, or by loading page), checks to see if the button (with name of 'submit') has been posted to the server, and if so, will run code inside if statement.
    if (isset($_POST['submit'])) {
        // Validation routines

        // DATE
        // Presence check
        if (empty($_POST['date'])) {
            $errors['date'] = 'Please ensure you enter a date. ';
        } else {
            $date = $_POST['date'];
        }

        // TIME
        // Presence check
        if (empty($_POST['time'])) {
            $errors['time'] = 'Please ensure you enter a time. ';
        } else {
            $time = $_POST['time'];
        }

        // Do nothing with errors since they are already being handled, if 'errors' array is empty then it is safe to create new user.
        if (array_filter($errors)) {
            // Echo for debug purposes
            //echo "Errors";
        } else {
            // Echo for debug purposes
            //echo "No errors";
            $date = mysqli_real_escape_string($connection, $_POST['date']);
            $time = mysqli_real_escape_string($connection, $_POST['time']);
            $datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
            $userId = $_SESSION['userId'];
  
            // Get the user_id from the username submitted in the form
            $sql = "INSERT INTO tbl_infections (user_id, date_time) VALUES ('$userId', '$datetime')";
            if (mysqli_query($connection, $sql)) {
                $success = 1;
            } else {
                echo "ERROR: Unable to get user id. " . mysqli_error($connection);
            }
        }
    }
?>