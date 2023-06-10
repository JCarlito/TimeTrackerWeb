<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['admin_key'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $admin_key = $_POST['admin_key'];

    if ($admin_key == 1234) {
        // First check if the username is already taken
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // No rows found, the username is not taken
            $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $username, $password);

            if ($stmt->execute()) {
                $_SESSION['logged_in'] = true;
                header('Location: ../admin.php');
            } else {
                header('Location: ../admin_register.html?error=' . urlencode("Error: " . $stmt->error));
            }
        } else {
            header('Location: ../admin_register.html?error=' . urlencode("Username is already taken"));
        }
    } else {
        header('Location: ../admin_register.html?error=' . urlencode("Invalid admin key"));
    }
} else {
    header('Location: ../admin_register.html?error=' . urlencode("Invalid form submission"));
}

// Close the database connection
CloseCon($conn);
?>
