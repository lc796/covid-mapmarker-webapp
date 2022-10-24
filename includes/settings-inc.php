<?php
    // Start session
    session_start();

    // Define 'errors' associative array, where a string will be associated with the 'username' error or 'password' error.
    $errors = array('window' => '', 'distance' => '');

    // Define 'success' variable as an integer (0 = unassigned, 1 = successful)
    $success = 0;

    // Define 'window' and 'distance' variables. Initialise as empty strings.
    $window = "";
    $distance = "";

    // When settings.php is called (either through clicking button on form, or by loading page), checks to see if the button (with name of 'submit') has been posted to the server, and if so, will run code inside if statement.
    if (isset($_POST['submit'])) {
        // Validation routines

        // WINDOW
        // Presence check
        if (empty($_POST['window'])) {
            $errors['window'] = 'Please ensure you enter a window. ';
        } else {
            $window = $_POST['window'];
        }

        // DISTANCE
        // Presence check
        if (empty($_POST['distance'])) {
            $errors['distance'] = 'Please ensure you enter a distance between 0 and 500. Cannot be 0 (since 0 as a distance cannot exist!)';
        } else {
            if (!is_numeric($_POST['distance'])) {
                $errors['distance'] = 'Please ensure your input is numerical.';
            } else {
                if ($_POST['distance'] <= 0 || $_POST['distance'] > 500) {
                    $errors['distance'] = 'Please ensure you enter a distance between 0 and 500.';
                } else {
                    $distance = preg_replace('/\s+/', '', $_POST['distance']);
                }
            }
        }

        // Do nothing with errors since they are already being handled, if 'errors' array is empty then it is safe to set cookies.
        if (array_filter($errors)) {
            // Echo for debug purposes
            //echo "Errors";
        } else {
            setcookie("window", $window, time() + 86400 * 30, "/");
            setcookie("distance", $distance, time() + 86400 * 30, "/");
            $success = 1;
        }
    }
?>