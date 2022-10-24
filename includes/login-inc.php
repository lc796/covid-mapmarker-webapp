<?php
    // Start session
    session_start();

    // Define 'errors' associative array, where a string will be associated with the 'username' error or 'password' error.
    $errors = array('username' => '', 'password' => '');

    // Define 'success' variable as an integer (0 = unassigned, 1 = successful)
    $success = 0;

    // Define 'username' and 'password' variables. Initialise as empty strings.
    $username = "";
    $password = "";

    // When login.php is called (either through clicking button on form, or by loading page), checks to see if the button (with name of 'submit') has been posted to the server, and if so, will run code inside if statement.
    if (isset($_POST['submit'])) {
        // Validation routines

        // USERNAME
        // Presence check
        if (empty($_POST['username'])) {
            $errors['username'] = 'Please ensure you enter a username. ';
        } else {
            $username = $_POST['username'];
        }

        // PASSWORD
        // Presence check
        if (empty($_POST['password'])) {
            $errors['password'] = 'Please ensure you enter a password.';
        } else {
            $password = $_POST['password'];
        }

        // Do nothing with errors since they are already being handled, if 'errors' array is empty then it is safe to create new user.
        if (array_filter($errors)) {
            // Echo for debug purposes
            //echo "Errors";
        } else {
            // Echo for debug purposes
            //echo "No errors";
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
  
            // Get the user_id from the username submitted in the form
            $sqlGetUserId = "SELECT user_id,password_hash,fname FROM tbl_user WHERE username='$username'";
            if (mysqli_query($connection, $sqlGetUserId)) {
                $selectedUserId = mysqli_query($connection, $sqlGetUserId);
                $row = mysqli_fetch_assoc($selectedUserId);
                if (!is_null($row)) {
                    // Echo for debug purposes
                    //echo "Successfully got user id: " . $row['user_id'];
                    $userId = $row['user_id'];
                    $passwordHash = $row['password_hash'];
                    $fname = $row['fname'];
  
                    // Should only redirect user and give success message if successful.
                    if (password_verify($password, $passwordHash)) {
                        $success = 1;
                        $_SESSION['userId'] = $userId;
                        $_SESSION['name'] = $fname;
                        header('Refresh:5; url=user-portal.php');
                    } else {
                        $success = 2;
                        // Echo for debug purposes
                        //echo "ERROR: Passwords do not match.";
                    }
                }
                else {
                    $success = 2;
                }
            } else {
                echo "ERROR: Unable to get user id. " . mysqli_error($connection);
            }
        }
    }
?>