<!DOCTYPE html>
<html>
    <?php
        require_once 'UserInfo.php';
        require_once 'database.php';
        session_start();
        $user = unserialize($_SESSION["user"]);
        
        // Update the user's data
        if(isset($_POST["Submit"])) {
            $username = $_POST["Username"];
            $seconds = $_POST["Seconds"];
            $minutes = 0;
            $hours = 0;
            
            while($seconds >= 60) {
                $minutes++;
                if($minutes == 60) {
                    $hours++;
                    $minutes = 0;
                }
                $seconds -= 60;
            }
            
            $check = "SELECT hours, minutes, seconds FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $check);
            $userFound = mysqli_fetch_assoc($result);
            
            if($userFound) {
                // Get the new data
                $newSeconds = $userFound['seconds'] + $seconds;
                $newMinutes = $userFound['minutes'] + $minutes;
                $newHours = $userFound['hours'] + $hours;

                // Increment if necessary
                if($newSeconds >= 60) {
                    $newMinutes++;
                    $newSeconds -= 60;
                }

                if($newMinutes >= 60) {
                    $newHours++;
                    $newMinutes -= 60;
                }
                
                // Store the new data
                $sql = "UPDATE users SET hours = '$newHours', minutes = '$newMinutes', seconds = '$newSeconds' WHERE username = '$username'";
                if(mysqli_query($conn, $sql)) {
                    echo '<div id="tracked-time"><p>Your tracked time was successful.</p><p>For this run, you tracked: '.$hours.' '.(($hours == 1) ? "Hour" : "Hours").', '.$minutes.' '.(($minutes == 1) ? "Minute" : "Minutes").', and '.$seconds.' '.(($seconds == 1) ? "Second" : "Seconds").'</p></div>';

                }
                else {echo 'Error uptading record: '.mysqli_error($conn);}
            }
        }
        
        // Display the user's current data
        $tmpUser = $user->getUsername();
        $check = "SELECT hours, minutes, seconds FROM users WHERE username = '$tmpUser'";
        $result = mysqli_query($conn, $check);
        $foundUser = mysqli_fetch_assoc($result);
        if($foundUser) {
            $user->setHours($foundUser["hours"]);
            $user->setMinutes($foundUser["minutes"]);
            $user->setSeconds($foundUser["seconds"]);
        }
        else {echo 'Error getting the user\'s information: '.mysqli_error($conn);}
        
        // Close DB
        mysqli_close($conn);
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
        <ul id="user-menu">
            <li>
                <button id="view-time" class="user-choices">View Time</button>
                <div id="dropdown-view" class="show-dropdown"></div>
            </li>
            <li>
                <button id="start-time" class="user-choices">Track New Time</button>
                <div id="dropdown-start" class="show-dropdown">
                    <ul class="instructions">
                        <li>1. Once you click on the button, your time will begin.</li>
                        <br><li>2. To end the time, click on the button again.</li>
                        <br><li>3. You can view your new time at the "View Time" section.</li>
                        <br><li id="message">Would you like to begin a new time?</li>
                        <br><li id="end-time"><button id="start" class="start-button">Start New Time</button></li><br>
                        
                    </ul>
                    <form action="UserPage.php" method="post" id="hide-form" name="update" onsubmit="doSomething()">
                        <div id="new-seconds"><input type="number" hidden value="0" name="Seconds"></div>
                        <div id="username-input"><input type="text" hidden value="Nothing" name="Username"></div>
                        <div id="submit-time"></div>
                    </form>

                </div>
            </li>
            <li><a href="logout.php" id="logout-user" class="user-choices">Log out</a></li>
        </ul>
    </div>
    <script>
        var begin = 0;
        var end = 0;
        var user = <?php echo json_encode($user); ?>;
        // Execute to view the time
        document.getElementById("view-time").onclick = function () {
            document.getElementById("dropdown-view").classList.toggle("show");
            let str = '<p>Here is your time:</p><p>Hours: '+user.hours+'</p><p>Minutes: '+user.minutes+'</p><p>Seconds: '+user.seconds+'</p>';
            document.getElementById("dropdown-view").innerHTML = str;
        };
        
        // Execute to start a new time
        document.getElementById("start-time").onclick = function () {
            document.getElementById("dropdown-start").classList.toggle("show");
        };
        document.getElementById("start").onclick = function () {
          begin = new Date().getTime() / 1000;
          document.getElementById("message").innerHTML = "<p>Your time has started, click on the button to end it.</p>";
          document.getElementById("submit-time").innerHTML = '<input id="submit-new" name="Submit" type="submit" value="End Time">';
          document.getElementById("end-time").innerHTML = "";
        };
        function doSomething() {
            end = new Date().getTime() / 1000;
            var seconds = parseInt(end - begin);
            document.getElementById("username-input").innerHTML = '<input type="text" hidden value="'+user.username+'" name="Username">';
            document.getElementById("new-seconds").innerHTML = '<input type="number" hidden value="'+seconds+'" name="Seconds">';
        }
    </script>
</html>
