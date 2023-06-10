<!DOCTYPE html>
<html>
    <?php
    require_once "database.php";
    // Execute if a modification has taken place
    if(isset($_POST["Submit"])) {
        $hours = $_POST["hours"];
        $minutes = $_POST["minutes"];
        $seconds = $_POST["seconds"];
        $username = $_POST["username"];
        
        $check = "SELECT user_id, hours, minutes, seconds FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $check);
        $userFound = mysqli_fetch_assoc($result);
        
        if($userFound) {
            // Get the new data
            $newSeconds = $userFound['seconds'] + $seconds;
            $newMinutes = $userFound['minutes'] + $minutes;
            $newHours = $userFound['hours'] + $hours;
            $id = $userFound['user_id'];
            
            // Increment if necessary
            if($newSeconds == 60) {
                $newMinutes++;
                $newSeconds = 0;
            }
            
            if($newMinutes == 60) {
                $newHours++;
                $newMinutes = 0;
            }
            else if ($newMinutes > 60) {
                $newHours++;
                $newMinutes %= 10;
            }
            
            // Store the new data
            $sql = "UPDATE users SET hours = '$newHours', minutes = '$newMinutes', seconds = '$newSeconds' WHERE user_id = '$id'";
            if(mysqli_query($conn, $sql)) {
                echo '<p>Update Successful</p>';
            }
            else {echo 'Error uptading record: '.mysqli_error($conn);}
        }
    }// Execute 'else if' if a deletion has taken place
    else if(isset($_POST["Delete"])) {
        $username = $_POST["username"];
        
        $sql = "DELETE FROM users WHERE username = '$username'";
        if(mysqli_query($conn, $sql)) {
            echo '<p>User successfully deleted.</p>';
        }
        else {echo 'Error deleting record: '.mysqli_error($conn);}
    }
    // Output the all data
    $check = "SELECT user_id, username, hours, minutes, seconds FROM users";
    $result = mysqli_query($conn, $check);
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }
    mysqli_close($conn);
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Viewing Users</title>
    </head>
    <div id="box">
        <div id="popup" class="popup">
            <form action="ViewUsers.php" method="post" id="edit-user"></form>
            <input type="button" id="exit" value="Exit">
        </div>
        <div class="popup" id="popup-delete">
            <form action="ViewUsers.php" method="post" id="delete-user"></form>
            <input type="button" id="cancel" value="Cancel">
        </div>
        <h1 id="welcome">Viewing Users</h1>
        <a href="AdminPage.php" class="returnAdmin">Return</a>
        <script>
            // Get user information
            var user = <?php echo json_encode($data)?>;
            
            // Display Information
            document.write('<table id="Users"><tr><th>UserID</th><th>Username</th><th>Hours</th><th>Minutes</th><th>Seconds</th></tr>');
            for(var i = 0; i < user.length; i++) {
                let obj = user[i];
                document.write('<tr class="rows">');
                for(var property in obj) {
                    document.write('<td class="data">'+obj[property]+'</td>');
                }
                document.write('<td><input type="button" class="edit-button" id="'+obj.username+'" value="Edit"</td>');
                document.write('<td><input type="button" class="delete-button" id="'+obj.username+'-delete" value="Delete"</td>');
                document.write('</tr>');
            }
            document.write("</table>");
            
            // Execute if the admin wishes to edit a user
            for(let i = 0; i < user.length; i++) {
                let tmp = user[i];
                document.getElementById(tmp.username).onclick = function() {
                    let popup = document.getElementById("popup");
                    popup.classList.add("open-popup");
                    let str = '<p id="header">'+tmp.username+'</p><p>Enter a positive value to add time.</p><p>Enter a negative value to subtract time.</p><input type="input" value="'+tmp.username+'" name="username" class="hidden"><br>';

                    for(let i in tmp) {
                        if(!(i === "username" || i === "user_id")) {
                            var max = 60 - tmp[i];
                            var min = tmp[i] * -1;
                            let label = i.charAt(0).toUpperCase() + i.slice(1);
                            str += '<label class="label" for="'+i+'">'+label+'</label><input name="'+i+'" type="number" value="0" id="'+i+'" min="'+min+'" max="'+max+'"><br>';
                        }
                    }

                    str += '<input type="submit" value="Submit" name="Submit" id="submit">';
                    document.getElementById("edit-user").innerHTML = str;
                };
            }
            
            // Execute if the admin wishes to delete a user
            for(let i = 0; i < user.length; i++) {
                let tmp = user[i];
                document.getElementById(tmp.username+"-delete").onclick = function() {
                    let str = '<h2>Are you sure you want to delete '+tmp.username+'? All existing data for this user will be gone.</h2><input type="input" value="'+tmp.username+'" name="username" class="hidden"><br><input type="submit" name="Delete" value="Delete" id="confirm-delete"><br>';
                    let popup = document.getElementById("popup-delete");
                    popup.classList.add("open-popup");
                    document.getElementById("delete-user").innerHTML = str;
                };
            }
             
            // Exit out of popup
            document.getElementById("exit").onclick = function() {
                let popup = document.getElementById("popup");
                popup.classList.remove("open-popup");
            };
            document.getElementById("cancel").onclick = function() {
                let popup = document.getElementById("popup-delete");
                popup.classList.remove("open-popup");
            }; 
        </script>
    </div>
</html>
