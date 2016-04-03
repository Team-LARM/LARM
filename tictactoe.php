<!DOCTYPE html>

<?php
    session_start();
    
    if(isset($_SESSION['userID'])) {
        $currentUser = $_SESSION['userID'];
    }
?>

<html>
<head>
    <title>LARM > TicTacToe Session</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
    </head>

<body>
    <div class="pageContainer">
    
        <div class="headerContainer">
        
            <div class="headerBanner">
            <div class="headerRight">
                <img src="images/tictactoe.png" alt="Tic Tac Toe" title="Tic Tac Toe" width="226" height="48">
                <?php 
                    echo '<a href="logout.php">LOGOUT</a>';
                    ?>               
            </div>
        </div>
        
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">
            <div id="gameInsert"><b><h1>PLAYER X TURN</h1></b>
            <table width=100%>
                <tr>
                    <td><button>CELLA1</button></td>
                    <td><button>CELLA2</button></td>
                    <td><button>CELLA3</button></td>
                </tr>
                <tr>
                    <td><button>CELLB1</button></td>
                    <td><button>CELLB2</button></td>
                    <td><button>CELLB3</button></td>
                </tr>
                <tr>
                    <td><button>CELLC1</button></td>
                    <td><button>CELLC2</button></td>
                    <td><button>CELLC3</button></td>
                </tr>
                </table>
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
