<?php
session_start();
include '../db_connection.php';

// Check if form is submitted
if (isset($_POST['edit_time'])) {
    $conn = OpenCon();

    // Get user_id, log_id, and new time from POST data
    $user_id = $_POST['user_id'];
    $log_id = $_POST['log_id'];
    $time = $_POST['time'];

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE time_log SET time = ? WHERE user_id = ? AND log_id = ?");

    // Bind parameters
    $stmt->bind_param("iii", $time, $user_id, $log_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Time updated successfully!";
        header('Location: ../edit_times.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
