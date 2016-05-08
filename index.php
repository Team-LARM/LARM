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
        <br><br>
        <img src="images/tictactoe.png" alt="tic tac toe" title="tic tac toe" width="301" height="64">
        <h2>-play tic tac toe online-</h2>
        <h2>-chat with a friend-</h2>
        <br><br>
        <p>To <b>start a game</b>, please <b>login</b> or <b>register</b></p>
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
