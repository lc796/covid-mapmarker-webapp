<?php
    // Makes database connection.
    include_once 'includes/config.php';

    // Uses add-visit-inc.
    include_once 'includes/add-visit-inc.php';

    $title = 'Add Visit';
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
            <a href="#" class="current">Add Visit</a>
            <a href="report.php">Report</a>
            <a href="settings.php">Settings</a>
            <div class="empty"></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="main">
            <div class="status">
                <div class="status-header">
                    <h2 id="table-heading">Add a new Visit</h2>
                    <hr>
                </div>
                <div class="status-text status-text-wrapper">
                    <form action="add-visit.php" method="POST">
                        <input type="date" class="add-visit-field username-password-fields" id="date" name="date" placeholder="Date" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8');?>">
                        <input type="time" class="add-visit-field username-password-fields" id="time" name="time" placeholder="Time" value="<?php echo htmlspecialchars($time, ENT_QUOTES, 'UTF-8');?>">
                        <input type="text" class="add-visit-field username-password-fields" id="duration" name="duration" placeholder="Duration" value="<?php echo htmlspecialchars($duration, ENT_QUOTES, 'UTF-8');?>">
                        <input type="hidden" id="x" name="x">
                        <input type="hidden" id="y" name="y">
                        <?php 
                            if ($success == 0) {
                                echo $errors['date'];
                                echo $errors['time'];
                                echo $errors['duration'];
                                echo $errors['xy'];
                            } elseif ($success == 1) {
                                echo "Success!";
                            }
                        ?>
                        <div class="add-visit-padding">
                            <button type="submit" class="add-visit-button" id="" name="submit" value="submit">Add</button>
                            <button type="button" class="add-visit-button" id="" onclick="clearFields();">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="status-map">
                    <div class="map-wrapper">
                        <img src="resources/exeter.jpg" alt="" id="map">
                        <img src="resources/marker_black.png" alt="" id="marker">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var map = document.getElementById("map");
        var marker = document.getElementById("marker");

        map.addEventListener('click', function (event) {
            bounds = this.getBoundingClientRect();
            var left = bounds.left;
            var top = bounds.top;
            var x = event.pageX - left - 15;
            var y = event.pageY - top - 30;
            
            document.getElementById("x").value = x+15;
            document.getElementById("y").value = y+30;

            move(marker, x, y);
        });

        function move(element, x, y) {
            marker.style.left = x + "px";
            marker.style.top = y + "px";
            marker.style.display = "inline";
        }
    </script>
    <script>
        function clearFields() {
            document.getElementById("date").value = "";
            document.getElementById("time").value = "";
            document.getElementById("duration").value = "";
            document.getElementById("x").value = "";
            document.getElementById("y").value = "";
            document.getElementById("marker").style.display = "none";
        }
    </script>
</body>
</html>