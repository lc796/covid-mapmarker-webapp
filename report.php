<?php
    // Makes database connection.
    include_once 'includes/config.php';

    // Uses report-inc.
    include_once 'includes/report-inc.php';

    $title = 'Report';
?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'includes/header.php'?>
    <?php
        if (!isset($_SESSION['userId'])) {
            header('Refresh:0; url=login.php');
        }
    ?>
    <div class="container">
        <div class="menu">
            <a href="home.php">Home</a>
            <a href="overview.php">Overview</a>
            <a href="add-visit.php">Add Visit</a>
            <a href="#" class="current">Report</a>
            <a href="settings.php">Settings</a>
            <div class="empty"></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="main">
            <div class="settings">
                <div class="status-header">
                    <h2 id="table-heading">Report an Infection</h2>
                    <hr>
                </div>
                <div class="settings-info">
                    <p>Please report the date and time when you were tested positive for COVID-19.</p>
                </div>
                <div class="settings-form">
                    <form action="report.php" method="POST">
                        <div class="settings-form-window">
                            <input type="date" name="date" id="date" class="username-password-fields">
                        </div>
                        <div class="settings-form-distance">
                            <input type="time" name="time" id="time" class="username-password-fields settings-form2">
                            <br><br>
                        </div>
                        <?php 
                            if ($success == 0) {
                                echo $errors['date'];
                                echo $errors['time'];
                            } elseif ($success == 1) {
                                echo "Success!";
                            }
                        ?>
                        <div class="settings-form-report-cancel">
                            <button type="submit" id="report" name="submit" value="submit" class="report">Report</button>
                            <button type="button" id="cancel" class="cancel-grid" onclick="clearFields();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function clearFields() {
            document.getElementById("date").value = "";
            document.getElementById("time").value = "";
        }
    </script>
</body>
</html>