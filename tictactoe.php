<?php echo '<!DOCTYPE html> <html>';

    include 'tictactoescripts.php';
    $turnMessage = "";
    $isTurnMessag = "";
    $game = "";
    $symbol = "";
    $currentUser = getCurrentUser();
    $board = getBoard($currentUser);
    
    $turn = getTurn($board);
    if ($turn == 1) {
        $turnMessage = "IT IS PLAYER O'S TURN";
        $symbol = "O";
    }
    else if ($turn == 0) {
        $turnMessage = "IT IS PLAYER X'S TURN";
        $symbol = "X";
    }
    
    $isTurn = getIsTurn($board, $currentUser, $turn);
    if ($isTurn == 1) {
        $isTurnMessage = "Make your move.";
    }
    else if ($isTurn == 0) {
        $isTurnMessage = "Please wait your turn.";
    }
    
    //load the 2D game array
    $gameArray = loadBoard($board);
    $A1 = $gameArray[0][0];
    $A2 = $gameArray[0][1];
    $A3 = $gameArray[0][2];
    $B1 = $gameArray[1][0];
    $B2 = $gameArray[1][1];
    $B3 = $gameArray[1][2];
    $C1 = $gameArray[2][0];
    $C2 = $gameArray[2][1];
    $C3 = $gameArray[2][2];
    
    $numTurns = getNumTurns($gameArray);
    
    if (isset($_POST['A1'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $A1, 0, 0);
    }
    else if (isset($_POST['A2'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $A2, 0, 1);
    }
    else if (isset($_POST['A3'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $A3, 0, 2);
    }
    else if (isset($_POST['B1'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $B1, 1, 0);
    }
    else if (isset($_POST['B2'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $B2, 1, 1);
    }
    else if (isset($_POST['B3'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $B3, 1, 2);
    }
    else if (isset($_POST['C1'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $C1, 2, 0);
    }
    else if (isset($_POST['C2'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $C2, 2, 1);
    }
    else if (isset($_POST['C3'])) {
        $game = game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $C3, 2, 2);
    }
	
	
    //load the 2D game array again to update the table with new info
    $gameArray = loadBoard($board);
    $A1 = $gameArray[0][0];
    $A2 = $gameArray[0][1];
    $A3 = $gameArray[0][2];
    $B1 = $gameArray[1][0];
    $B2 = $gameArray[1][1];
    $B3 = $gameArray[1][2];
    $C1 = $gameArray[2][0];
    $C2 = $gameArray[2][1];
    $C3 = $gameArray[2][2];
    
    $turn = getTurn($board);
    if ($turn == 1) {
        $turnMessage = "IT IS PLAYER O'S TURN";
        $symbol = "O";
    }
    else if ($turn == 0) {
        $turnMessage = "IT IS PLAYER X'S TURN";
        $symbol = "X";
    }
    //If it is the player's turn, quit reloading the page and notify them that it is their turn.
    $isTurn = getIsTurn($board, $currentUser, $turn);
    if ($isTurn == 1) {
		echo ' <script type="text/javascript"> 
			if( autoRefreshVar != "undefined"){
				clearInterval(autoRefreshVar);
			}
			</script>';
        $isTurnMessage = "Make your move.";
    }
    else if ($isTurn == 0) {
        $isTurnMessage = "Please wait your turn.";
    }
    
echo '<script type="text/javascript">

function getPage(){
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		document.body.innerHTML = xmlhttp.responseText;
	}
    }
        xmlhttp.open("GET", "tictactoe.php", true);
		xmlhttp.send();
 }
var autoRefreshVar = setInterval(getPage,1000);
		</script>';
		
		
echo'
<head>
    <title>LARM > TicTacToe Session</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
</head>

<body>

    <div class="pageContainer">
    
        <div class="headerContainer">
        
            <div class="headerBanner">
            <div class="headerRight">
                <img src="images/tictactoe.png" alt="Tic Tac Toe" title="Tic Tac Toe" width="226" height="48">';
                echo '<a href="logout.php">LOGOUT</a>';
            echo '</div>
        </div>
        
            <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    
        <div class="bodyContainer">
            <div id="gameInsert">
            <b><h1>';
			echo $turnMessage;
			echo '</h1></b>
            <h2>';
			echo $isTurnMessage;
			echo '</h2>
            <h2>'; 
			echo $game; 
			echo '</h2>
            <form name="gameForm" method="POST" action="';
			echo htmlspecialchars($_SERVER["PHP_SELF"]);
			echo '">
            <table id="gameTable" width=100%>
                <tr>
                    <td><input type="submit" name="A1" onclick="getPage()" value="';
                                                                if (strcmp($A1, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $A1;
                                                                };
																echo'"></td>
                    <td><input type="submit" name="A2" onclick="getPage()" value="';
                                                                if (strcmp($A2, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $A2;
                                                                };
																echo '"></td> 
                    <td><input type="submit" name="A3" onclick="getPage()" value="';
                                                                if (strcmp($A3, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $A3;
                                                                };
																echo'"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="B1" onclick="getPage()" value="';
                                                                if (strcmp($B1, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $B1;
                                                                };
																echo '"></td>
                    <td><input type="submit" name="B2" onclick="getPage()" value="';
                                                                if (strcmp($B2, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $B2;
                                                                };
																echo '"></td>
                    <td><input type="submit" name="B3" onclick="getPage()" value="';
                                                                if (strcmp($B3, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $B3;
                                                                };
																echo '"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="C1" onclick="getPage()" value="';
                                                                if (strcmp($C1, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $C1;
                                                                };
																echo '"></td>
                    <td><input type="submit" name="C2" onclick="getPage()" value="';
                                                                if (strcmp($C2, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $C2;
                                                                };
																echo '"></td>
                    <td><input type="submit" name="C3" onclick="getPage()" value="';
                                                                if (strcmp($C3, "N") == 0) {
                                                                    echo "";
                                                                }
                                                                else {
                                                                    echo $C3;
                                                                };
																echo '"></td>
                </tr>
            </table>
            </form>
            </div>
        </div>

        <div class="footerContainer">
			<!-- <input type="submit" name="testMe" onclick="getPage()"> -->

            <div class="footerLeft">
            <a href="about.php" target="_blank">ABOUT US</a>
            </div>';
			echo '<div class="footerRight">
            <img src="images/HTML5_Badge_64.png" alt="made with HTML5" title="made with HTML5" width="32" height="32">
            <a href="https://github.com/team-larm/LARM" target="_blank"><img src="images/GitHub-Mark-64px.png" alt="visit project on GitHub" title="visit project on GitHub" height="32" width="32"></a>
            </div>
        </div>

    </div>
</body>
</html>'; ?>
