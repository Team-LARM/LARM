<!DOCTYPE html>
<?php

    include 'scripts.php';
    session_start();
    
    $currentUser = $message = $deleteID = $readID = "";
    
    if(isset($_SESSION['userID'])) {
        $currentUser = $_SESSION['userID'];
        $inboxMessages = getInbox($currentUser);
        $sentMessages = getSent($currentUser);
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            
            if (isset($_POST["inboxdelete"])) {
                $message = deleteMessage($_POST["inboxdelete"]);
                $deleteID = $_POST["inboxdelete"];
            }

            if (isset($_POST["inboxopen"])) {
                $message = getMessage($_POST["inboxopen"]);
                markRead($_POST["inboxopen"]);
                $readID = $_POST["inboxopen"];
                
            }
            
            if (isset($_POST["sentdelete"])) {
                $message = deleteMessage($_POST["sentdelete"]);
                $deleteID = $_POST["sentdelete"];
            }
            
            if (isset($_POST["sentopen"])) {
                $message = getMessage($_POST["sentopen"]);
                $readID = $_POST["sentopen"];
            }
                
        }
    }

    

?>


<html>
<head>
    <title>LARM > Chat</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
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
            <h2>Personal Messages</h2>
            
            <div id="messagesInsert">
            <!--Messaging Block--><fieldset>
            <legend>Send a Message</legend>
            
                    <form method="POST" action="validatepm.php" name="personalMessage">

                    <div id="nameForm">to (userID):<br>
                    <input type="text" name="to" value="" 
                        maxlength="35" size="28" required /></div>

                    <div id="subjectForm">subject:<br>
                    <input type="text" name="subject" value=""
                        maxlength="35" size="28" required /></div>

                    <div id="messageForm">
                        <textarea name="message" required></textarea>
                        <br><br>
                        <input type="submit" name="submit" value="submit" /></div>
                    </form>
            </fieldset><!--END Messaging Block-->
            <br>
                
            <!--Inbox Block--><fieldset>
            <legend>Inbox</legend>
                <?php
                    echo "<form method='POST' action='";
                    htmlspecialchars($_SERVER["PHP_SELF"]);
                    echo "'><table>
                                <th>New</th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <th>Action</th>";
                    for ($int = count($inboxMessages) - 1; $int >= 0; $int-- ) {
                        echo "<tr><td>";
                        if ($inboxMessages[$int]["read"] == false) {
                            echo "<img src='glyphicons/png/glyphicons-310-comments.png' alt='new 
                            message' width='15' height='15'/>";
                            }
                        echo "</td><td><b>";
                        echo $inboxMessages[$int]["sender"];
                        echo "</b></td><td>";
                        echo $inboxMessages[$int]["subject"];
                        echo "</td><td>";
                        echo $inboxMessages[$int]["date"];
                        echo "</td><td><button type='submit' name='inboxopen' value='";
                        echo $inboxMessages[$int]["id"];
                        echo "'>open</button>";
                        echo "<button type='submit' name='inboxdelete' value='";
                        echo $inboxMessages[$int]["id"];
                        echo "'>delete</button></td></tr>";
                        
                        
                        if($deleteID != "") {
                            if ($inboxMessages[$int]["id"] == $deleteID)  
                                echo "<tr><td colspan='5'><div id='deleteMessage'>
                                $message</div></td></tr>";
                                //header("Refresh:3; url=personal_messages.php");
                        }
                        
                        if($readID != "") {
                            if ($inboxMessages[$int]["id"] == $readID)
                                echo "<tr><td colspan='5'><div id='readMessage'>$message</div></td></tr>";      
                        }
                    }
                    
            
                    ?>

                </table>
                
        
            </fieldset><!--END Inbox Block-->
            <br>   
            <!--Sent Mail Block--><fieldset>
                <legend>Sent Messages</legend>
                    <?php
                    echo "<table>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <th>Action</th>";
                    
                    for ($int2 = count($sentMessages) - 1; $int2 >= 0; $int2-- ) {
                        echo "<tr><td><b>";
                        echo $sentMessages[$int2]["recipient"];
                        echo "</b></td><td>";
                        echo $sentMessages[$int2]["subject"];
                        echo "</td><td>";
                        echo $sentMessages[$int2]["date"];
                        echo "</td><td><button type='submit' 
                        name='sentopen' value='";
                        echo $sentMessages[$int2]["id"];
                        echo "'>open</button>";
                        echo "<button type='submit' name='sentdelete' value='";
                        echo $sentMessages[$int2]["id"];
                        echo "'>delete</button></td></tr>";
                        
                        
                        if($deleteID != "") {
                            if ($sentMessages[$int2]["id"] == $deleteID)
                                echo "<tr><td colspan='5'><div
                                id='deleteMessage'>$message</div></td></tr>";
                        }
                        
                        if($readID!= "") {
                            if ($sentMessages[$int2]["id"] == $readID)
                                echo "<tr><td colspan='5'><div
                                id='readMessage'>$message</div></td></tr>";     
                        }
                    }?>
                    </table>
                    </form>
            </fieldset><!--END Sent Mail Block-->
  
		</div>
        
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
