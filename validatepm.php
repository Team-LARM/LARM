<!DOCTYPE html>

<?php
    
    include 'scripts.php';
    session_start();
    $currentUser = "";
    $alertMessage = "";
    $to = $subject = $message = "";
    
    if(isset($_SESSION['userID']))
        $currentUser = $_SESSION['userID'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // establish message variables from post information
        $to = $_POST["to"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        // Query for recipient's ID
        try {
            $dbh = connectMySQL();
            $stmt = $dbh->prepare("SELECT `ID_Number` FROM `USER` WHERE
            User_ID=:User_ID");
            $stmt->bindParam(':User_ID', $to, PDO::PARAM_STR);
            $stmt->execute();
            $stmtReturn = $stmt->fetchall(PDO::FETCH_ASSOC);
            $dbh = $stmt = null;
        }
        
        catch (Exception $e) {
            $alertMessage = "Recipient not found";
        }
        
        if ($message == "" || $subject == "") {
            $alertMessage = "Subject and message are both required fields";
        }
        
        // Otherwise, continue with query.  Find sender's username and insert the new
        // message into the database.
        else {
            
            
            // Query for username of sender
            try {
                $recipient_id = $stmtReturn[0]["ID_Number"];
                $dbh = connectMySQL();
                $stmt = $dbh->prepare("SELECT `User_ID` FROM `USER` WHERE 
                User_ID=:User_ID");
                $stmt->bindParam(':User_ID', $currentUser, PDO::PARAM_INT);
                $stmt->execute();
                $stmtReturn = $stmt->fetchall(PDO::FETCH_COLUMN);
                $sender = $stmtReturn[0];
                $dbh = $stmt = null;
            }

            catch (Exception $e) {
                $alertMessage = "Recipient not found";
            }

            // Update messages table to include new message (effectively, send)

            try {
                $dbh = connectMySQL();
                $stmt = $dbh->prepare("INSERT INTO `messages` (`sender`, `sender_id`, `recipient`,
                `recipient_id`, `subject`, `message`) VALUES (:sender, :sender_id, :recipient, :recipient_id, :subject, :message)");
                $stmt->bindParam(':sender', $sender, PDO::PARAM_STR);
                $stmt->bindParam(':sender_id', $currentUser, PDO::PARAM_INT);
                $stmt->bindParam(':recipient', $to, PDO::PARAM_STR);
                $stmt->bindParam(':recipient_id', $recipient_id, PDO::PARAM_INT);
                $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
                $stmt->bindParam(':message', $message, PDO::PARAM_STR);
                $stmt->execute();
                $dbh = $stmt = null;
            }

            catch (Exception $e) {
                $alertMessage = "Recipient not found";
            }
        }
    }
?>

<html>
<head>
    <title>LARM > Welcome</title>
    <link href="css/messages.css" type="text/css" rel="stylesheet" />
    </head>

<body>
    <div class="pageContainer">
    
        <div class="headerContainer">
        
            <div class="headerBanner">
            <div class="headerRight">
                <a href="gameslanding.php">GAMES</a>
                <a href="logout.php">LOGOUT</a>              
            </div>
        </div>
        
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">
            <?php
                // If no alert message, send was successful, refresh back to personal
                // messages page
                if($alertMessage == "") {
                    echo "<h2>MESSAGE SENT</h2><p>Refreshing...</p>";
                    header("Refresh:3; url=personal_messages.php");
                }
            
                // Otherwise, re-display the form with information filled in and
                // let them know that the recipient's userID was not valid.
                else {
                    echo $alertMessage;?>
                    <br><br>
                    <!--Messaging Block--><fieldset>
                    <legend>Send a Message</legend>

                        <form method="POST" action="validatepm.php" name="personalMessage">

                        <div id="nameForm">to (userID):<br>
                        <input type="text" name="to" value="<?php echo $to ?>" 
                            maxlength="35" size="28" required /></div>

                        <div id="subjectForm">subject:<br>
                        <input type="text" name="subject" value="<?php echo $subject ?>"
                            maxlength="35" size="28" required /></div>


                        <div id="messageForm">
                            <textarea name="message" required><?php echo $message ?></textarea>
                            <br><br>
                            <input type="submit" name="submit" value="submit" /></div>
                        </form>
                </fieldset><!--END Messaging Block-->
                <?php } ?>    
        
        </div>
        
            <div class="footerContainer">
        
                <div class="footerLeft">
                <a href="about.php" target="_blank">ABOUT US</a>
                    </div>
    
                <div class="footerRight">
                    <img src="images/HTML5_Badge_64.png" alt="made with HTML5" title="made with HTML5" width="32" height="32">
                    <a href="https://github.com/team-larm/LARM" target="_blank"><img src="images/GitHub-Mark-64px.png" alt="visit project on GitHub" title="visit project on GitHub" height="32" width="32"></a>
                    </div>
                </div>
        </div>
    </body>
    
</html>
