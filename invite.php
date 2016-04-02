<!DOCTYPE html>

<?php
include 'scripts.php';
session_start();
$currentUser = "";
$message = "";
    
/* Check if user is logged in */
if (isset($_SESSION['userID'])) {
    $currentUser = $_SESSION['userID'];
    echo "<p>Invite someone to play a game with you, $currentUser.</p>";
}
else {
    echo "<p>Please log in.</p>";
}
    
if ($_SERVER["REQUEST_METHOD"]=="POST") {
        
    if(strlen($_POST['inviteUser']) == 0) { //no user ID entered
        $message = 'Please enter in a user ID.';
    }
    else {
        /* Store the user to be invited in $inviteUser */
        $inviteUser = filter_var($_POST['inviteUser'], FILTER_SANITIZE_STRING);
        
        /* Connect to the database */
        $dbh = connectMySQL();
        
        try { // attempt to update the databse
            
            // construct MySQL statement and execute
            $stmt = $dbh->prepare("SELECT User_ID FROM USER WHERE User_ID = :inviteUser");
            $stmt->bindParam(':inviteUser', $inviteUser, PDO::PARAM_STR);
            $stmt->execute();
            
            // get the result from the database
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $inviteID = $result['User_ID'];
            
            // database request did not return anything
            if ($inviteID == false) {
                $message = 'User ID not found';
            }
            // prevent user from sending themselves an invitation
            elseif ($inviteID == $currentUser) {
                $message = 'You cannot send yourself an invitation.';
            }
            else {
                // update the database
                $stmt = $dbh->prepare("UPDATE USER SET Invite='$currentUser' WHERE User_ID='$inviteUser'");
                $stmt->execute();
                
                // see if the database updated
                $rows_updated = $stmt->rowCount();
                if ($rows_updated == 0) {
                    $message = 'Unable to send that user an invitation.';
                }
                else{
                    $message = 'You have successfully sent '.$inviteID.' an invitation.';
                }
            }
        }
        catch(Exception $e) {
            $message = 'We are unable to process your request.  Please contact the webadmin';
        }
    }
}
?>

<html>
<head>
    <title>LARM > Games</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <div class="pageContainer">

        <div class="headerContainer">
            <div class="headerBanner">
            <div class="headerRight">
            <a href="logout.php">LOGOUT</a>
            </div>
            </div>
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176 height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <label for="inviteUser">Enter the User ID of another player: </label>

            <input type="text" name="inviteUser" id="inviteUser" size="20" value="" maxlength="20" />
            
            <input type="submit" value="&rarr; Invite" />
            </form>
            <p><?php
                // Display message
                echo $message;
                ?>
            </p>
        </div>
        
        <div class="footerContainer">
            <div class="footerLeft">
            <a href="about.php">ABOUT US</a>
            </div>
            <div class="footerRight">
                <img src="images/HTML5_Badge_64.png" alt="made with HTML5" title="made with HTML5" width="32" height="32">
                <a href="https://github.com/team-larm/LARM"><img src="images/GitHub-Mark-64px.png" alt="visit project on GitHub" title="visit project on GitHub" height="32" width="32"></a>
            </div>
        </div>
    </div>

</body>
    
</html>