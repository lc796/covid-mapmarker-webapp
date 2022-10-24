<?php
    // Makes database connection.
    include_once 'includes/config.php';

    $title = 'Overview';
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
            <a href="#" class="current">Overview</a>
            <a href="add-visit.php">Add Visit</a>
            <a href="report.php">Report</a>
            <a href="settings.php">Settings</a>
            <div class="empty"></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="main">
            <table class="overview-table">
                <tr>
                    <th class="field">Date</th>
                    <th class="field">Time</th>
                    <th class="field">Duration</th>
                    <th class="field">X</th>
                    <th class="field">Y</th>
                    <th class="field"></th>
                </tr>
                <?php
                    $userId = $_SESSION['userId'];

                    $sql = "SELECT visit_id,date_time,duration,x,y FROM tbl_visits WHERE user_id='$userId'";
                    if (mysqli_query($connection, $sql)) {
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $datetime = $row['date_time'];
                            $date = date('Y-m-d', strtotime("$datetime"));
                            $time = date('H:i:s', strtotime("$datetime"));
                            echo '<tr id="' . 'row' . $row['visit_id'] . '">';
                            echo '<td class="field">' . $date . '</td>';
                            echo '<td class="field">' . $time . '</td>';
                            echo '<td class="field">' . $row['duration'] . '</td>';
                            echo '<td class="field">' . $row['x'] . '</td>';
                            echo '<td class="field">' . $row['y'] . '</td>';
                            echo '<td class="field"><a href="#" onclick="removeRow(\'' . $row['visit_id'] . '\');"><img src="resources/cross.png" style="height: 25px;"></src></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo mysqli_error($connection);
                        $success = 2;
                    }
                ?>
            </table>
        </div>
    </div>
    <script>
        function removeRow(rowId) {
            document.getElementById("row" + rowId).style.display = "none";

            var xhttp = new XMLHttpRequest();

            xhttp.open("POST", "includes/remove.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("visit_id=" + rowId);
        }
    </script>
</body>
</html>