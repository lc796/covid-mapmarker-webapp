<?php
    // Makes database connection.
    include_once 'includes/config.php';

    // Uses login-inc.
    include 'includes/register-inc.php';

    $title = 'Register';
?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'includes/header.php'?>
    <?php 
    if (isset($_SESSION['userId'])) {
        header('Refresh:0; url=home.php');
    } else {
    ?>
    <div class="main">
        <form class="login-register-form" action="register.php" method="POST">
            <input type="text" class="username-password-fields" id="fname" name="fname" placeholder="Name" value="<?php echo htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');?>">
            <input type="text" class="username-password-fields" id="lname" name="lname" placeholder="Surname" value="<?php echo htmlspecialchars($lname, ENT_QUOTES, 'UTF-8');?>">
            <input type="text" class="username-password-fields" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>">
            <input type="password" class="username-password-fields" id="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8');?>">

            <?php
            if ($success == 1) {
                echo "Account created successfully! Redirecting you to login page now...";
            } else {
                echo $errors['fname'];
                echo $errors['lname'];
                echo $errors['username'];
                echo $errors['password'];
            }
            ?>
            
            <br><br>
            <button type="submit" id="register" name="submit" value="submit">Register</button>
        </form>
    </div>
    <?php
    }
    ?>
</body>
</html>