<?php
    // Makes database connection.
    include_once 'includes/config.php';

    // Uses settings-inc.
    include_once 'includes/settings-inc.php';

    $title = 'Settings';
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
            <a href="report.php">Report</a>
            <a href="#" class="current">Settings</a>
            <div class="empty"></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="main">
            <div class="settings">
                <div class="status-header">
                    <h2 id="table-heading">Alert Settings</h2>
                    <hr>
                </div>
                <div class="settings-info">
                    <p>Here you may change the alert distance and the time span for which the contact tracing will be performed.</p>
                </div>
                <div class="settings-form">
                    <form action="settings.php" method="POST">
                        <div class="settings-form-window">
                            <label for="window">window</label>
                            <!-- <input type="text" name="window" id="window" class="username-password-fields"> -->
                            <select id="window" name="window" class="username-password-fields">
                                <option value="1">1 week</option>
                                <option value="2">2 weeks</option>
                                <option value="3">3 weeks</option>
                                <option value="4">4 weeks</option>
                            </select>
                        </div>
                        <div class="settings-form-distance">
                            <label for="distance">distance</label>
                            <input type="text" name="distance" id="distance" class="username-password-fields settings-form2" value="<?php echo htmlspecialchars($distance, ENT_QUOTES, 'UTF-8');?>">
                            <br><br>
                            <?php 
                                if ($success == 0) {
                                    echo $errors['window'];
                                    echo $errors['distance'];
                                } elseif ($success == 1) {
                                    echo "Success!";
                                }
                            ?>
                        </div>
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
            document.getElementById("window").value = "";
            document.getElementById("distance").value = "";
        }
    </script>
</body>
</html>