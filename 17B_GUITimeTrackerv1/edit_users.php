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
<htm1> 
    <head>
        <title>Admin - Edit Users</title>
        <style>
            /* CSS styles for the page layout */
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                padding: 20px;
            }

            h1 {
                text-align: center;
                margin-top: 20px;
                color: #333;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
            }

            th {
                background-color: #4CAF50;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #fafafa;
            }

            form {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
            }

            form input[type="text"],
            form input[type="password"] {
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 5px;
                margin: 5px;
            }

            form label {
                margin-right: 10px;
            }

            form input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            form input[type="submit"]:hover {
                background-color: #45a049;
            }

            /* CSS styles for the home button */
            .home-button {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                padding: 8px 16px;
                text-decoration: none;
                font-size: 16px;
                border-radius: 4px;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .home-button:hover {
                background-color: #45a049;
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
                <th>Password</th>
            </tr>
            <?php
            $conn = OpenCon();
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='php_scripts/edit_user.php' method='post' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
                    echo "<input type='text' name='username' value='" . $row["username"] . "' required>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='password' name='password' placeholder='Leave blank to keep current password' style='width: 220px'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<label><input type='radio' name='status' value='1' " . ($row['status'] == 1 ? 'checked' : '') . ">Activate</label>";
                    echo "<label><input type='radio' name='status' value='0' " . ($row['status'] == 0 ? 'checked' : '') . ">Deactivate</label>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='submit' value='Edit User' name='edit_user'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>NO USERS!</td></tr>";
            }
            ?>
        </table>
    </body>
</html>
