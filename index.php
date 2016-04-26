<!DOCTYPE html>

<!-- Leaving homepage as PHP so we can display login information -->

<?php
    session_start();
    $currentUser = "";

if(isset($_SESSION['userID'])) {
    $currentUser = $_SESSION['userID'];
}
?>

<html>
<head>
    <title>LARM > Welcome</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
    </head>

<body>
    <div class="pageContainer">
    
    <div class="headerContainer">
        <div class="headerBanner">
            <div class="headerRight">
            <?php 
            if($currentUser != "") {
                echo '<a href="logout.php">LOGOUT</a>
                        <a href="gameslanding.php">GAMES</a>';
            }
            
            else {
                echo '<a href="login.php">LOGIN</a>
                    <a href="register.php">REGISTER</a>';
            }?>
            </div>
        </div>
        <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    <div class="bodyContainer">

        <p><b>Welcome to LARM gaming.</b> With this site, any user can play tic tac toe with any other existing user. It is a collaborative site that allows people to join together and play games!</p>

        <p>To <b>start a game</b>, either <b>login</b> or <b>register</b></p>

        <p>Registering is easy-- you only need a username and password between 5-20 characters.</p>

        <p>Once logged in, you can send and recieve invitations to play tic tac toe. Accepted invitations automatically start games between players. Sent invitations do not start until the invited player accepts and overwrite any previous game.</p>

	<p><b>Start playing!</b></p>
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
