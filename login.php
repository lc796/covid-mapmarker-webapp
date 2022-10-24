<?php
    // Makes database connection.
    include_once 'includes/config.php';

    // Uses login-inc.
    include 'includes/login-inc.php';

    $title = 'Login';
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
        <form class="login-register-form" action="login.php" method="POST">
            <input type="text" class="username-password-fields" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>">
            <input type="password" class="username-password-fields" id="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8');?>">
            <?php
                if ($success == 0) {
                    echo $errors['username'];
                    echo $errors['password'];
                } elseif ($success == 1) {
                    echo "Logging you in now!";
                } elseif ($success == 2) {
                    echo "Incorrect username and/or password!";
                }
            ?>
            <br><br>
            <div class="aligned-horizontal-buttons">
                <button type="submit" id="login" name="submit" value="submit">Login</button>
                <button type="button" id="cancel" onclick="clearFields();">Cancel</button>
            </div>
            <a href="register.php"><button type="button" id="register">Register</button></a>
        </form>
    </div>
    <?php
    }
    ?>
    <script>
        function clearFields() {
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
        }
    </script>
</body>
</html>