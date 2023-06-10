<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

if ($_SESSION['logged_in'] === false) {
    header('Location: sign_in.html');
}

include 'db_connection.php';
$conn = OpenCon();

if (isset($_POST['start'])) {
    $_SESSION['start_time'] = time();
}

if (isset($_POST['stop'])) {
    if (isset($_SESSION['start_time'])) {
        $end_time = time();
        $total_time = $end_time - $_SESSION['start_time'];
        $session_date_time = date('Y-m-d H:i:s');
        $user_id = $_SESSION['user_id']; 
        
        // Prepare an SQL statement for execution
        $stmt = $conn->prepare("INSERT INTO time_log (user_id, date, time) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user_id, $session_date_time, $total_time);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Time logged successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        unset($_SESSION['start_time']);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Study Time Tracker</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }
            form {
                margin-bottom: 20px;
            }
            input[type=submit], button {
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
                color: white;
            }
            input[type=submit] {
                background-color: #007BFF;
            }
            input[type=submit]:hover {
                background-color: #0056b3;
            }
            button {
                background-color: #28a745;
            }
            button:hover {
                background-color: #1e7e34;
            }
            .sign-out-btn {
                padding: auto;
                background-color: #dc3545;
            }
            .sign-out-btn:hover {
                background-color: #c82333;
            }
            
            #sign-out-form{
                margin-top: 20px;
            }
            
            
        </style>
    </head>
    <body>
        <h1>Study Time Tracker</h1>
        <form method="post">
            <input type="submit" name="start" value="Start Study Session">
            <input type="submit" name="stop" value="Stop Study Session">
        </form>
        <button onclick="location.href = 'user_view_time.php'">View Time Stats</button>
        <form id="sign-out-form" action="php_scripts/sign_out.php" method="post">
            <button type="submit" class="sign-out-btn">Sign Out</button>
        </form>
    </body>
</html>