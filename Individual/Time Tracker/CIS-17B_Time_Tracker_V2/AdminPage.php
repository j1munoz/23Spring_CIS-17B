<!DOCTYPE html>
<html>
    <?php
        session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Home</title>
    </head>
    <div id="box">
        <h1 id="welcome">Welcome, 
            <?php
                $admin = $_SESSION["admin"];
                echo $admin;
            ?>
        </h1>
        <ul id="nav">
            <li><a href="ViewUsers.php">View Users</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
</html>
