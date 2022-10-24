<?php
    // Start session
    session_start();

    // Define 'errors' associative array, where a string will be associated with the 'username' error or 'password' error.
    $errors = array('date' => '', 'time' => '', 'duration' => '', 'xy' => '');

    // Define 'success' variable as an integer (0 = unassigned, 1 = successful)
    $success = 0;

    // Define 'date', 'time', 'duration', 'x', and 'y' variables. Initialise as empty strings.
    $date = "";
    $time = "";
    $duration = "";
    $x = "";
    $y = "";

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

        // DURATION
        // Presence check
        if (empty($_POST['duration'])) {
            $errors['duration'] = 'Please ensure you enter a duration. ';
        } else {
            if (!is_numeric($_POST['duration'])) {
                $errors['duration'] = 'Please ensure your input is numerical. ';
            } else {
                if ($_POST['duration'] <= 0) {
                    $errors['duration'] = 'Please ensure you enter a duration greater than 0. ';
                } else {
                    $duration = preg_replace('/\s+/', '', $_POST['duration']);
                }
            }
        }

        // X
        // Presence check
        if (empty($_POST['x'])) {
            $errors['xy'] = 'Please ensure you select a marker!';
        } else {
            $x = $_POST['x'];
        }

        // Y
        // Presence check
        if (empty($_POST['y'])) {
            $errors['xy'] = 'Please ensure you select a marker!';
        } else {
            $y = $_POST['y'];
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
            $duration = mysqli_real_escape_string($connection, $_POST['duration']);
            $x = mysqli_real_escape_string($connection, $_POST['x']);
            $y = mysqli_real_escape_string($connection, $_POST['y']);
            $datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
            $userId = $_SESSION['userId'];
  
            // Get the user_id from the username submitted in the form
            $sql = "INSERT INTO tbl_visits (user_id, date_time, duration, x, y) VALUES ('$userId', '$datetime', '$duration', '$x', '$y')";
            if (mysqli_query($connection, $sql)) {
                $success = 1;
            } else {
                echo "ERROR: Unable to access database: " . mysqli_error($connection);
            }
        }
    }
?>