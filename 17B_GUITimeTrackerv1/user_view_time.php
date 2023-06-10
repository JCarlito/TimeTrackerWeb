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
    exit();
}

include 'db_connection.php';
$conn = OpenCon();

$user_id = $_SESSION['user_id']; 

$stmt = $conn->prepare("SELECT date, time FROM time_log WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$total_time = 0;
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Time Stats</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
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
            p {
                font-size: 18px;
                font-weight: bold;
            }
            button {
                padding: 10px 20px;
                border: none;
                background-color: #28a745;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            button:hover {
                background-color: #1e7e34;
            }
        </style>
    </head>
    <body>
        <h1>Time Stats</h1>
        <table>
            <tr>
                <th>Date</th>
                <th>Length (seconds)</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { 
                $total_time += $row['time']; ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <p>Total study time: <?php echo secondsToTime($total_time); ?></p>
        <button class="return-btn" onclick="location.href='timetracker.php'">Return to Time Tracker</button>
    </body>
</html>

