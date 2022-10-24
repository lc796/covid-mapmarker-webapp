<?php
    // Makes database connection.
    include_once 'includes/config.php';

    $title = 'Home';
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
            <a href="#" class="current">Home</a>
            <a href="overview.php">Overview</a>
            <a href="add-visit.php">Add Visit</a>
            <a href="report.php">Report</a>
            <a href="settings.php">Settings</a>
            <div class="empty"></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="main">
            <div class="status">
                <div class="status-header">
                    <h2 id="table-heading">Status</h2>
                    <hr>
                </div>
                <div class="status-text status-text-wrapper">
                    <div class="status-text-top">
                        <p>Hi <?php echo $_SESSION['name'];?>, you might have had a connection to an infected person at the location shown in red.</p>
                    </div>
                    <div class="status-text-bottom">
                        <p>Click on the marker to see details about the infection.</p>
                    </div>
                </div>
                <div class="status-map">
                    <div class="map-wrapper">
                        <img src="resources/exeter.jpg" alt="" id="map">
                        <?php
                            if (isset($_COOKIE['window']) && isset($_COOKIE['distance'])) {
                                $window = $_COOKIE['window'];
                                $distance = $_COOKIE['distance'];
                                $userId = $_SESSION['userId'];

                                // Populate array of all visits (i.e., where the visit is made by another user, and where the infection and visit are both within the time window.
                                $sql1 = "SELECT * FROM tbl_visits WHERE date_time BETWEEN DATE_SUB(CURDATE(), INTERVAL $window WEEK) AND CURDATE()";
                                $sql2 = "SELECT user_id FROM tbl_infections WHERE date_time BETWEEN DATE_SUB(CURDATE(), INTERVAL $window WEEK) AND CURDATE()";
                                $result = mysqli_query($connection, $sql1);
                                $result2 = mysqli_query($connection, $sql2);
                                $all_visits = array();
                                foreach ($result as $row) {
                                    foreach ($result2 as $row2) {
                                        if ($row['user_id'] != $userId && $row['user_id'] == $row2['user_id']) {
                                            array_push($all_visits, $row);
                                        }
                                    }
                                }

                                // Populate array of user visits
                                $sql3 = "SELECT * FROM tbl_visits WHERE user_id='$userId'";
                                $result3 = mysqli_query($connection, $sql3);
                                $user_visits = array();
                                foreach ($result as $userRow) {
                                    array_push($user_visits, $row);
                                }

                                // Determine black or red
                                $black_markers = array();
                                $red_markers = array();
                                foreach ($all_visits as $visit) {
                                    foreach($user_visits as $visit2) {
                                        $distanceAct = sqrt(($visit['x'] - $visit['y']) ** 2 + ($visit['x'] - $visit['y']) ** 2);
                                        if ($distanceAct <= $distance) {
                                            array_push($red_markers, $visit);
                                        } else {
                                            array_push($black_markers, $visit);
                                        }
                                    }
                                }

                                foreach($black_markers as $marker) {
                                    echo '<img src="resources/marker_black.png" style="display: inline; position: absolute; top: ' . $marker['x'] . 'px; left: ' . $marker['y'] . 'px; height: 30px; width: auto;"></img>';
                                }

                                foreach($red_markers as $marker) {
                                    echo '<img src="resources/marker_red.png" style="display: inline; position: absolute; top: ' . $marker['x'] . 'px; left: ' . $marker['y'] . 'px; height: 30px; width: auto;"></img>';
                                }
                            } else {
                                echo "Please set your settings!";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>