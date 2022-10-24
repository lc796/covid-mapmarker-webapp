<?php
    // Start session
    session_start();

    // Makes database connection.
    include_once 'includes/config.php';

    // Define 'errors' associative array, where a string will be associated with the error.
    $errors = array('username' => '', 'password' => '', 'fname' => '', 'lname' => '');

    // Define 'success' variable as a boolean (0 = false)
    $success = 0;
  
    // Define variables from form. Initialise as empty strings.
    // Must be global because user could go to register.php (i.e. from navbar) without clicking the button, in which case an error would show in trying to fetch the value to populate the empty field with.
    $username = "";
    $password = "";
    $fname = "";
    $lname = "";

    // When register.php is called (either through clicking button on form, or by loading page), checks to see if the button (name of 'submit') has been posted to the server, and if so, will run code inside if statement.
    if (isset($_POST['submit'])) {

        // Validation routines

        // USERNAME
        // Presence check for username input
        if (empty($_POST['username'])) {
            $errors['username'] = 'Please ensure you enter a username. ';
        } else {
            // Length check (max of 30 characters)
            $username = $_POST['username'];
            if (strlen($username) > 30) {
                $errors['username'] = 'Maximum 30 characters allowed. ';
            } else {
                // Format check (only alphanumeric allowed) using regex
                $usernameRegex = "/^[A-Za-z0-9]+$/";
                if (!preg_match($usernameRegex, $username)) {
                    $errors['username'] = 'Username must be alphanumeric. ';
                } else {
                    // Lookup check to disallow duplicate usernames
                    $usernameCheck = mysqli_query($connection, "SELECT username FROM tbl_user WHERE username='$username'");
                    $usernameRowCount = mysqli_num_rows($usernameCheck);
                    if ($usernameRowCount >= 1) {
                        $errors['username'] = 'Username must be unique. This username is already taken. ';
                    } else {
                    // Echo for debug purposes
                    //echo htmlspecialchars($_POST['username']) . '<br>';
                    }
                }        
            }
        }

        // PASSWORD
        // Presence check for password input
        if (empty($_POST['password'])) {
            $errors['password'] = 'Please ensure you enter a password. ';
        } else {
            // Length check (max of 30 characters, minimum of 8 characters)
            $password = $_POST['password'];
            if (strlen($password) > 30 || strlen($password) < 8) {
                if (strlen($password) > 30 ) {
                    $errors['password'] = 'Maximum 30 characters allowed. ';
                } else {
                $errors['password'] = 'Passwords must be at least 8 characters. ';
                } 
            } else {
                // Echo for debug purposes
                //echo htmlspecialchars($_POST['password']) . '<br>';
            }
        }

        // FNAME
        // Presence check for fname input
        if (empty($_POST['fname'])) {
            $errors['fname'] = 'Please ensure you enter a name. ';
        } else {
            // Length check (max of 30 characters)
            $fname = $_POST['fname'];
            if (strlen($fname) > 30) {
                $errors['fname'] = 'Maximum 30 characters allowed. ';
            } else {
                // Format check (letters only)
                $fnameRegex = "/^[A-Za-z\-]+$/";
                if (!preg_match($fnameRegex, $fname)) {
                    $errors['fname'] = 'Name must only contain letters. ';
                } else {
                    // Echo for debug purposes
                    //echo htmlspecialchars($_POST['fname']) . '<br>';
                }
            }
        }

        // LNAME
        // Presence check for lname input
        if (empty($_POST['lname'])) {
        } else {
            // Length check (max of 30 characters)
            $lname = $_POST['lname'];
            if (strlen($lname) > 30) {
                $errors['lname'] = 'Maximum 30 characters allowed. ';
            } else {
                // Format check (letters only)
                $lnameRegex = "/^[A-Za-z\-]+$/";
                if (!preg_match($lnameRegex, $lname)) {
                    $errors['lname'] = 'Name must only contain letters. ';
                } else {
                    // Echo for debug purposes
                    //echo htmlspecialchars($_POST['lname']) . '<br>';
                }
            }
        }

        // Do nothing with errors since they are already being handled, if 'errors' array is empty then it is safe to create new user.
        if (array_filter($errors)) {
            // Echo for debug purposes
            //echo "Errors";
        } else { // This 'else' statement is the code that is run assuming that the form has no errors. This is where interaction with DB should be made, using the $connection variable defined in /includes/config.php
            // Echo for debug purposes
            //echo "No errors";

            // Prevent SQL injection by escaping dangerous SQL.
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $fname = mysqli_real_escape_string($connection, $_POST['fname']);
            $lname = mysqli_real_escape_string($connection, $_POST['lname']);

            // Use PHP's inbuilt BCRYPT hashing algorithm as it provides a salt with the hash.
            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
            // Create new user in tbl_user with the provided information.
            $sql = "INSERT INTO tbl_user (username, password_hash, fname, lname) VALUES ('$username', '$passwordHashed', '$fname', '$lname')";
            if (mysqli_query($connection, $sql)) {
                // Echo for debug purposes
                //echo "Records added successfully.";
                //echo $passwordHashed;
                //header("Location: index.php");
            } else {
                //echo "ERROR: Unable to execute $sql. " . mysqli_error($connection);
            }

            // Cannot use elseif statement, since the form uses checkbox rather than radio, which means that a user could select all options, in which case not all options will be handled unless using separate if statements.
            // We must create the user before we can create the user role since it references the user_id which cannot otherwise exist.
            $sqlGetUserId = "SELECT user_id FROM tbl_user WHERE username='$username'";
            if (mysqli_query($connection, $sqlGetUserId)) {
                $selectedUserId = mysqli_query($connection, $sqlGetUserId);
                $row = mysqli_fetch_assoc($selectedUserId);
                // Echo for debug purposes
                //echo "Successfully got user id: " . $row['user_id'];
                $user_id = $row['user_id'];
            } else {
                echo "ERROR: Unable to get user id. " . mysqli_error($connection);
            }
        
            $success = 1;
            header('Refresh:5; url=login.php');
        }
    }
?>