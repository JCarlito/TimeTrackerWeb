<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // This is the plaintext password the user entered

    // Retrieve the stored hashed password
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, now we need to verify the password.
        $user = $result->fetch_assoc();
        $storedPassword = $user['password']; // This is the hashed password stored in the database

        if (password_verify($password, $storedPassword)) {
            // Password is valid, create new session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['admin_id'] = $user['admin_id'];
            header('Location: ../admin.php');
        } else {
            // Invalid password
            header('Location: ../admin_login.html?error=' . urlencode("Invalid password"));
        }
    } else {
        // No user found with the entered username
        header('Location: ../admin_register.html?error=' . urlencode("No user found with that username"));
    }
} else {
    // Invalid form submission
    header('Location: ../admin_login.html?error=' . urlencode("Invalid form submission"));
}

// Close the database connection
CloseCon($conn);


