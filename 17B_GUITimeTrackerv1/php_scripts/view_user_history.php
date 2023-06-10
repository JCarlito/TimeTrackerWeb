<!DOCTYPE html>
<html>
    <head>
        <title>Admin - Purchase History</title>
        <style>
            /* CSS styles for the page layout */
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                padding: 20px;
            }

            h1 {
                text-align: center;
                margin-top: 20px;
                color: #333;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
            }

            th {
                background-color: #f2f2f2;
                color: #555;
            }

            tr:nth-child(even) {
                background-color: #fafafa;
            }

            p {
                margin: 10px 0;
            }

            /* CSS styles for the admin menu button */
            .admin-menu-button {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                padding: 8px 16px;
                text-decoration: none;
                font-size: 16px;
                border-radius: 4px;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .admin-menu-button:hover {
                background-color: #45a049;
            }

            /* CSS styles for the return button */
            .return-button {
                display: block;
                text-align: center;
                margin-top: 20px;
            }

            .return-button a {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                padding: 8px 16px;
                text-decoration: none;
                font-size: 16px;
                border-radius: 4px;
            }

            .return-button a:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();

        function secondsToTime($seconds) {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;

            return "$hours hour(s), $minutes minute(s), $seconds second(s)";
        }

        if (!isset($_SESSION['logged_in'])) {
            $_SESSION['logged_in'] = false;
        }

        if ($_SESSION['logged_in'] === false) {
            header('Location: sign_in.html');
        }
        include '../db_connection.php';

        $conn = OpenCon();

        if (isset($_POST['history'])) {

            $user_id = $_POST['user_id'];

            // fetch user's study times
            $sql = "SELECT time_log.date, time_log.time FROM time_log WHERE time_log.user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Admin menu button to return to "admin.php"
            echo "<a class='admin-menu-button' href='../admin.php'>Admin Menu</a>";

            echo "<h1>User's Study Times</h1>";

            echo "<table>";
            echo "<tr>";
            echo "<th>Date</th>";
            echo "<th>Time</th>";
            echo "</tr>";

            $totalTime = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $totalTime += $row['time'];
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data found!</td></tr>";
            }
            echo "<tr>";
            echo "<td>Total Time</td>";
            echo "<td>" . secondsToTime($totalTime) . "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<div class='return-button'>";
            echo "<a href='../view_users_time.php'>Return to Time History</a>";
            echo "</div>";
        }

        // Close the database connection
        CloseCon($conn);
        ?>

    </body>
</html>
