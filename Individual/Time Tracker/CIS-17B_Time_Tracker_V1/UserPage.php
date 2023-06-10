<!DOCTYPE html>
<html>
    <?php
        require_once 'UserInfo.php';
        require_once 'database.php';
        session_start();
        $user = unserialize($_SESSION["user"]);
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>User Page</title>
    </head>
    <div id="box">
        <h1 id="welcome">
            <?php
                echo 'Welcome, '.$user->getUsername();
            ?>
        </h1>
        <a href="logout.php" id="logout-user" class="user-choices">Log out</a>
    </div>
</html>
