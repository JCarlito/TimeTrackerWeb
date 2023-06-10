<?php
session_start();
include '../db_connection.php';
$conn = OpenCon();

// Check if a session is ongoing
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

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect user
header('Location: ../sign_in.html');
?>
