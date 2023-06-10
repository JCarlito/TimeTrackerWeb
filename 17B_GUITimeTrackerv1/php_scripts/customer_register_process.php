<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $status = 1;

    // Check if the username is already taken
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // No rows found, the username is not taken
        $stmt = $conn->prepare("INSERT INTO users (username, password, status) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $username, $password, $status);

        if ($stmt->execute()) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $conn->insert_id;
            header('Location: ../timetracker.php');
        } else {
            header('Location: ../customer_register.html?error=' . urlencode("Error: " . $stmt->error));
        }
    } else {
        header('Location: ../customer_register.html?error=' . urlencode("Username is already taken"));
    }
} else {
    header('Location: ../customer_register.html?error=' . urlencode("Invalid form submission"));
}

// Close the database connection
CloseCon($conn);
?>
