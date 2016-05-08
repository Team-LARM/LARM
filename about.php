<!DOCTYPE html>

<?php
    session_start();
    $currentUser = "";

    if(isset($_SESSION["userID"])){
        $currentUser = $_SESSION["userID"];
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
                    if($currentUser != ""){
                        echo '
                            <a href="gameslanding.php">GAMES</a>
                            <a href="personal_messages.php">CHAT</a>
                            <a href="logout.php">LOGOUT</a>';
                    }
                
                    else {
                        echo '
                            <a href="login.php">LOGIN</a>
                            <a href="register.php">REGISTER</a>';
                    }?>
            </div>
        </div>
        
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">
        <h1>About Project</h1>
            <p>A basic collaborative game website, created for CS 386 at Northern Arizona University</p>
            <br>
            <h1>About Us</h1>
            
            <br>
            <img src="images/ell.png" alt="Leia Trice" title="Leia Trice" width="27" height="40"> <b>eia Trice</b>
            <p>Game Logic, User Testing</p>
            <p>JavaScript, HTML, AJAX</p>
            
            <br>
            <img src="images/a.png" alt="Anna Moyers" title="Anna Moyers" width="35" height="40"> <b>nna Moyers</b>
            <p>Graphics / UI, Database</p>
            <p>HTML, CSS, PHP</p>
            
            <br>
            <img src="images/r.png" alt="Ryan Ladwig" title="Ryan Ladwig" width="30" height="40"><b>yan Ladwig</b>
            <p>Game Logic, Database</p>
            <p>JavaScript, PHP, AJAX</p>
            
            <br>
            <img src="images/m.png" alt="Marjorie Hahn" title="Marjorie Hahn" width="40" height="40"><b>arjorie Hahn</b>
            <p>Game Logic, Database</p>
            <p>Javascript, PHP, MySQL</p>

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