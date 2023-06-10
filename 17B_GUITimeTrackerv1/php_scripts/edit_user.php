<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();
if (isset($_POST['edit_user'])) {
    $id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = $_POST['status'];


    $stmt = $conn->prepare("UPDATE users SET username=?, password=?, status=? WHERE user_id=?");
    $stmt->bind_param('ssii', $username, $password, $status, $id);
    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating item: " . $stmt->error;
    }
} else {
    echo "Invalid form submission";
}
// Close the database connection
CloseCon($conn);
// Redirect back to the shopping cart page
header('Location: ../edit_users.php');
?>
