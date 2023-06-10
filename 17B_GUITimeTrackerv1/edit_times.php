<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

if ($_SESSION['logged_in'] === false) {
    header('Location: sign_in.html');
}
?>

<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Admin - Edit Times</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }

            .home-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: white;
                text-decoration: none;
                margin-bottom: 20px;
                transition: background-color 0.3s;
            }

            .home-button:hover {
                background-color: #0056b3;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            th {
                background-color: #007BFF;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            input[type=text] {
                width: 100%;
                padding: 6px 12px;
                margin: 5px 0;
                box-sizing: border-box;
            }

            input[type=submit] {
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
                color: white;
                background-color: #28a745;
            }

            input[type=submit]:hover {
                background-color: #1e7e34;
            }
        </style>
    </head>
    <body>
        <!-- Home Button -->
        <a class="home-button" href="admin.php">Home</a>

        <h1>Edit Users</h1>
        <table>
            <tr>
                <th>Username</th> 
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php
            $conn = OpenCon();
            $sql = "SELECT users.username, time_log.date, time_log.time, time_log.user_id, time_log.log_id FROM time_log INNER JOIN users ON time_log.user_id = users.user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<form action='php_scripts/edit_time.php' method='post' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
                    echo "<input type='hidden' name='log_id' value='" . $row["log_id"] . "'>";  // log_id is included here
                    echo "<td><input type='text' name='time' value='" . $row['time'] . "' required></td>";
                    echo "<td><input type='submit' value='Edit Time' name='edit_time'></td>";
                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>NO DATA!</td></tr>";
            }
            ?>
        </table>
    </body>
</html>


