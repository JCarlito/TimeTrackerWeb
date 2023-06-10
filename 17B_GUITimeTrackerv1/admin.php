<?php
session_start();

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
        <title>Admin - Menu</title>
        <style>
            :root {
                --main-bg-color: #333;
                --hover-bg-color: #111;
                --main-text-color: white;
            }

            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: var(--main-bg-color);
                color: var(--main-text-color);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            h1 {
                text-align: center;
                margin-bottom: 50px;
            }

            ul.navbar {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            ul.navbar li {
                margin-bottom: 20px;
            }

            ul.navbar li a {
                display: inline-block;
                background-color: var(--main-bg-color);
                color: var(--main-text-color);
                padding: 15px 30px;
                border: 2px solid var(--main-text-color);
                text-decoration: none;
                transition: all 0.3s ease;
            }

            ul.navbar li a:hover {
                background-color: var(--hover-bg-color);
            }
            .sign-out-btn {
                position: fixed;
                top: 20px;
                left: 20px;
                background-color: #4CAF50;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                font-size: 16px;
                cursor: pointer;
                border: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <h1>Welcome to the Admin Page</h1>

        <!-- Navigation bar -->
        <ul class="navbar">
            <li><a href="edit_users.php">Edit Users</a></li>
            <li><a href="edit_times.php">Edit Time</a></li>
            <li><a href="view_users_time.php">View User's Time</a></li>
        </ul>
        <form id="sign-out-form" action="php_scripts/sign_out.php" method="post">
            <button type="submit" class="sign-out-btn">Sign Out</button>
        </form>
    </body>
</html>
