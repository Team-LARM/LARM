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

    <script type = "text/javascript">
            var turn = 0;
            var tot_turns = 0;
            var gameArray = [];

            for (var i=0; i<3; i++) {
                gameArray.push([]);
                for (var j=0; j<3; j++){
                    gameArray[i].push("N");
                }
            }
            
            function win(array, player) {
                //checks all three rows, but stops if one is a win
                for (var i = 0; i < 3; i++) {
                    if (checkRow(array,i,player)) {
                        return true;    //one of the rows is a win
                    }
                }
                //None of the rows were a win, checks all three cols and stops if one is a win
                for (var i = 0; i < 3; i++) {
                    if (checkCol(array,i,player)) {
                        return true;    //one of the cols is a win
                    }
                }
                //Neither the rows or cols were a win, checks diagonals and stops if win
                for (var i = 0; i < 3; i+=2) {
                    if (checkDiag(array, i, player)) {
                        return true;
                    }
                }
                //diagonals weren't a win either, return false
                return false;
            }

            function checkRow(array, row, player) {
                for (var i = 0; i < 3; i++) {
                    if (array[row][i] != player){
                        return false;   //One of the spots in the row is not the player's
                    }
                }
                return true;    //All of the spots in the row belong to the player
            }

            function checkCol(array, col, player) {
                for (var i = 0; i < 3; i++){
                    if (array[i][col] != player) {
                        return false;   //One of the spots in the column is not the player's
                    }
                }
                return true;    //All of the spots in the col belong to the player
            }

            function checkDiag(array, col, player) {
                //Check the starting index and the middle index belong to the player
                //The else ifs vary based on the staring index of the diagonal and check the same
                //if they all belong to the player, returns true
                if (array[1][1] != player || array[0][col] != player) {
                    return false;
                } else if (col == 0 && array[2][2] != player) {
                    return false;
                } else if (col == 2 && array[2][0] != player) {
                    return false;
                } else {
                    return true;
                }
            }
            
            function game(clicked_id) {
                //Check buttons haven't already been clicked and there haven't been more turns than allowed
                if (document.getElementById(clicked_id).textContent != "X" && document.getElementById(clicked_id).textContent != "O" && tot_turns < 9) {
                    //X's turn
                    if (turn == 0) {
                        //Change button text and change value in gameArray
                        document.getElementById(clicked_id).innerText = "X";
                        gameArray[parseInt(clicked_id[0])][parseInt(clicked_id[1])] = "X";
                        //Check for win. If not a win, checks if all moves have been made. If so, Cat's game; if not, switches players 
                        if (win(gameArray,"X")){
                            document.getElementById("turnState").innerHTML = "X won!";
                            tot_turns = 9;  //Game over. No more playing.
                        } else if ((tot_turns += 1) == 9){
                            document.getElementById("turnState").innerHTML = "Cat's game!";
                        } else{
                            document.getElementById("turnState").innerHTML = "O's turn!";
                        }
                    //O's turn
                    } else {
                        document.getElementById(clicked_id).innerText = "O";
                        gameArray[parseInt(clicked_id[0])][parseInt(clicked_id[1])] = "O";
                        //Check for win. If not a win, checks if all moves have been made. If so, Cat's game; if not, switches players
                        if (win(gameArray,"O")){
                            document.getElementById("turnState").innerHTML = "O won!";
                            tot_turns = 9;  //Should not be able to play anymore
                        } else if ((tot_turns += 1) == 9) {
                            document.getElementById("turnState").innerHTML = "Cat's game!";
                        }
                        else{
                            document.getElementById("turnState").innerHTML = "X's turn!";
                        }
                    }
                    turn = (turn + 1) % 2;  //Switches turns
                }
                else if (tot_turns >= 9) {
                    //do nothing. Game is over.
                } else {
                    document.getElementById("turnState").innerHTML = "That button is already taken!";   //Keeps players from pressing already used buttons
                }       
            }
    </script>

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
            <div id="gameInsert"><b><h1 id="turnState">PLAYER X TURN</h1></b>
            <table width=100%>
                <tr>
                    <td><button id ="00" onclick="game(this.id)"></button></td>
                    <td><button id ="01" onclick="game(this.id)"></button></td>
                    <td><button id="02" onclick ="game(this.id)"></button></td>
                </tr>
                <tr>
		    <td><button id ="10" onclick="game(this.id)"></button></td>
                    <td><button id ="11" onclick="game(this.id)"></button></td>
                    <td><button id=12" onclick ="game(this.id)"></button></td>
                </tr>
                <tr>
                    <td><button id ="20" onclick="game(this.id)"></button></td>
                    <td><button id ="21" onclick="game(this.id)"></button></td>
                    <td><button id="22" onclick ="game(this.id)"></button></td>
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
