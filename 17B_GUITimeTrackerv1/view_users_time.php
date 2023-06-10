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
        <title>Admin - View Time History</title>
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

        <h1>View User Time History</h1>
        <table>
            <tr>
                <th>Username</th> 
                <th>Actions</th>
            </tr>
            <?php
            $conn = OpenCon();
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>";
                    echo "<form action='php_scripts/view_user_history.php' method='post'>";
                    echo "<input type='hidden' name='username' value='" . $row["username"] . "'>";
                    echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
                    echo "<input type='submit' name='history' value='View User's Time'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No users found!</td></tr>";
            }
            ?>
        </table>
    </body>
</html>
