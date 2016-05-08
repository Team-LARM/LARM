<!DOCTYPE html>

<?php
    include 'scripts.php';
    session_start();
    $currentUser = "";
    $topMesssage = "";
    $botMessage = "";
    
    // flags for displaying buttons
    $contGame = 0;
    $accInv = 0;
    
    // variables to hold the user's invitation and the user's board
    $inviteUser = "";
    $boardNum = "";

    // Check if user is logged in
    if(isset($_SESSION['userID'])) {
        $currentUser = $_SESSION['userID'];
        $topMessage = 'Would you like to play a game '.$currentUser.'?';
    }
    else {
        $topMessage = 'Please log in first: ';
    }
    
    // Connect to the database
    $dbh = connectMySQL();
    
    // check if the user has any invitations or games going
    try {
        $stmt = $dbh->prepare("SELECT Invite, Board FROM USER WHERE User_ID = '$currentUser'");
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $inviteUser = $result['Invite'];
        $board = $result['Board'];
        
        if ($inviteUser != NULL) {
            $accInv = 1;
        }
        
        if ($board != NULL) {
            $contGame = 1;
        }
    }
    catch (Exception $e) {
        $botMessage = 'We are unable to process your request. Please contact the webadmin';
    }
    
    // if the Continue Game button was clicked
    if (!empty($_POST['continueSubmit'])) {
        header("Location: tictactoe.php");
        exit;
    }
    
    // if the New Game button was clicked
    if (!empty($_POST['newSubmit'])) {
        header("Location: invite.php");
        exit;
    }
    
    // if the Accept Invitation was clicked
    if (!empty($_POST['acceptSubmit'])) {
        
        // find old board
        $stmt = $dbh->prepare("SELECT BOARD_NUM FROM BOARD WHERE BOARD_NUM='$board'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $boardNum = $result['BOARD_NUM'];
        
        // user had a game going, delete it
        if ($boardNum != NULL) {
            // delete old board
            $stmt = $dbh->prepare("DELETE FROM BOARD WHERE BOARD_NUM='$boardNum'");
            $stmt->execute();
            
            // check if the board was deleted successfully
            $rowsDeleted = $stmt->rowCount();
            if ($rowsDeleted == 0) { // unsuccessful deletion
                $botMessage = 'Database error. Unsuccessful board delete.';
            }
            else { // board deleted, remove old board num from both users' tables
                $stmt = $dbh->prepare("UPDATE USER SET Board=NULL WHERE Board IN('$boardNum')");
                $stmt->execute();
                
                // check if the board num was removed successfully
                $rowsDeleted = $stmt->rowCount();
                if ($rowsDeleted == 0) { // unsuccessful
                    $botMessage = 'Database error. Unsuccessful board delete.';
                }
            }
        }
        
        // Create a new board
        $stmt = $dbh->prepare("INSERT INTO BOARD (PLAYERX, PLAYERO, TURN) VALUES ('$currentUser', '$inviteUser', '$currentUser')");
        $stmt->execute();
            
        // check if new board was created successfully
        $rowsInserted = $stmt->rowCount();
        if ($rowsInserted == 0) { // no boards were created
            $botMessage = 'Database error. Unsuccessful board insert.';
        }
        else { // new board created, update board num of both users
                
            // get the ID of the newly created board
            $stmt = $dbh->prepare("SELECT BOARD_NUM FROM BOARD WHERE PLAYERX='$currentUser' and PLAYERO='$inviteUser'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $boardNum = $result['BOARD_NUM'];
            
            if ($boardNum == false) { // no boards were found
                $botMessage = 'Database error. Unsuccessful board selection.';
            }
            else { // board found, update user database
                // place the ID of the new board into the users' records
                $stmt = $dbh->prepare("UPDATE USER SET Board='$boardNum' WHERE User_ID IN('$currentUser', '$inviteUser')");
                $stmt->execute();
                
                // check if records were updated successfully
                $rowsUpdated = $stmt->rowCount();
                if ($rowsUpdated == 0) { // no rows were updated
                    $botMessage = 'Database error. Unsuccessful user update.';
                }
                else { // user records updated successfully
                    $botMessage = 'You have started a new game with '.$inviteUser.'.';
                    $contGame = 1; // show the continue game button
                    
                    // clear the user's invitation
                    $stmt = $dbh->prepare("UPDATE USER SET Invite=NULL WHERE User_ID='$currentUser'");
                    $stmt->execute();
                    
                    // check if invitation cleared
                    $rowsUpdated = $stmt->rowCount();
                    if ($rowsUpdated == 0) { // invitation not cleared
                        $botMessage = 'Database error. Unsuccessful invitation update.';
                    }
                    else { // invitation cleared
                        $accInv = 0; // do not show the invitation button
                    }
                }
            }
        }
    } // end Accept Invitation
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
                <a href="personal_messages.php">CHAT</a> 
                <a href="logout.php">LOGOUT</a>
            </div>
            </div>
        
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">

            <h3>
            <?php
                echo $topMessage;
                echo '</h3>';
                if ($topMessage == 'Please log in first: ') {
                    echo "<a href='login.php'>CLICK HERE</a>";
                }
            ?>
            </p>

            <p><?php echo $botMessage; ?></p>

            <form name="continueGame" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <?php
                    if ($contGame == 1) {
                        echo "<p><input type='submit' name='continueSubmit' value='Continue Game'></p>";
                    }
                    else {
                        echo "<p>You do not have any games going on.</p>";
                    }
                ?>
            </form>

            <form name="newGame" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><input type='submit' name='newSubmit' value='New Game'></p>
            </form>

            <form name="accept" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <?php
                    if ($accInv == 1) {
                        echo "<p>You have a pending invitation from $inviteUser: <input type='submit' name='acceptSubmit' value='Accept Invitation'></p>";
                    }
                    else {
                        echo "<p>You currently do not have any pending game invitations.</p>";
                    }
                ?>
            </form>

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