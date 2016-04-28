<?php
function connectMySQL () {
    $hostname = '';
    $username = '';
    $password = '';
    $dbName = '';
    
    try {
        $dbh = new PDO("mysql:host=$hostname; dbname=$dbName", $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }
    catch(Exception $e) {
        return null;
    }
	
}

//start a session to get the current user's userID
function getCurrentUser () {
    session_start();
    if(isset($_SESSION['userID'])) {
		$currentUser=$_SESSION['userID'];
        return $_SESSION['userID'];
    }
    else { //not logged in, give them the boot
        header("url=index.php");
    }
}

//generic function to retrieve results from a MySQL select statement
//returns what the select statement retrieved
function selectDB ($sql_stmt) {
    //connect to DB
    $dbh = connectMySQL();
    try {
        //create and execute the MySQL statement
        $stmt = $dbh->prepare($sql_stmt);
        $stmt->execute();
        
        //return the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    catch (Exception $e) {
        return null;
    }
}
    
//generic function to perform a MySQL delete or update or add statement
//returns 0 if nothing is updated, 1 if anything is updated, null if there was an exception error
function updateDB ($sql_stmt) {
    //connect to DB
    $dbh = connectMySQL();
        
    try {
        //create and execute the MySQL statement
        $stmt = $dbh->prepare($sql_stmt);
        $stmt->execute();
        
        //check if anything was updated
        $rowsUpdated = $stmt->rowCount();
        if ($rowsUpdated == 0) {
            return 0; //nothing was updated
        }
        else {
            return 1; //at least one record was updated
        }
    }
    catch (Exception $e) {
        return 0;
    }
}

//function that retrieves the PK of the user's board
function getBoard ($currentUser) {
    //get the board's primary key
    $board_num = selectDB("SELECT Board FROM USER WHERE User_ID='$currentUser'");
    return $board_num['Board'];
}



//returns a 0 ("X") or a 1 ("O") based on whose turn it currently is
function getTurn ($board_num) {
    //get database info on player turn and player user ids
    $result = selectDB("SELECT PLAYERX, PLAYERO, TURN FROM BOARD WHERE BOARD_NUM='$board_num'");

    //separate results into variables
    $playerx = $result['PLAYERX'];
    $playero = $result['PLAYERO'];
    $turnUser = $result['TURN'];
    
    //return 0 or 1
    if (strcmp($playerx, $turnUser) == 0) {
        return 0; //playerx's turn
    }
    else if (strcmp($playero, $turnUser) == 0) {
        return 1; //playero's turn
    }
}
    
function getIsTurn($board_num, $currentUser, $turn) {
    
    if ($turn == 1) { //check playero
        $result = selectDB("SELECT PLAYERO FROM BOARD WHERE BOARD_NUM='$board_num'");
        $result = $result['PLAYERO'];
    }
    else if ($turn == 0) { //check playerx
        $result = selectDB("SELECT PLAYERX FROM BOARD WHERE BOARD_NUM='$board_num'");
        $result = $result['PLAYERX'];
    }
    
    //compare the result to the current userID
    if (strcmp($currentUser, $result) == 0) {
        return 1; //it is the current user's turn
    }
    else {
        return 0; //it is not the current user's turn
    }
}

//returns an array that represents the game board from the database
function loadBoard($board_num) {
    $result = selectDB("SELECT CELLA1, CELLA2, CELLA3, 
                               CELLB1, CELLB2, CELLB3,
                               CELLC1, CELLC2, CELLC3
                       FROM BOARD
                       WHERE BOARD_NUM='$board_num'");
                       
    $gameArray = array(array($result['CELLA1'], $result['CELLA2'], $result['CELLA3']),
                       array($result['CELLB1'], $result['CELLB2'], $result['CELLB3']),
                       array($result['CELLC1'], $result['CELLC2'], $result['CELLC3']));
                       
    return $gameArray;
}


function getWinner ($currentUser){
	$b_num = getBoard($currentUser);
	$winner = selectDB("SELECT WINNER FROM BOARD WHERE BOARD_NUM='$b_num'");
	if($winner['WINNER'] == "No"){
		return "No Winner";
	}
	return $winner['WINNER'];
	
}
//helper function to get the total number of turns played
function getNumTurns($array) {
                       
    $numTurns = 0;
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            //if the position in the game array is not "N"
            if(strcmp($array[$i][$j], "N") != 0) {
                $numTurns++;
            }
        }
    }
    return $numTurns;
}
                       
//returns userID of the player whose turn it is
function getPlayer($board_num, $turn) {
    if ($turn == 1) { //player O
        $player = selectDB("SELECT PLAYERO FROM BOARD WHERE BOARD_NUM='$board_num'");
        $player = $player['PLAYERO'];
    }
    else { //player X
        $player = selectDB("SELECT PLAYERX FROM BOARD WHERE BOARD_NUM='$board_num'");
        $player = $player['PLAYERX'];
    }
    return $player;
}
                       
function saveGame($board_num, $gameArray, $turn) {
    
    $A1 = $gameArray[0][0];
    $A2 = $gameArray[0][1];
    $A3 = $gameArray[0][2];
    $B1 = $gameArray[1][0];
    $B2 = $gameArray[1][1];
    $B3 = $gameArray[1][2];
    $C1 = $gameArray[2][0];
    $C2 = $gameArray[2][1];
    $C3 = $gameArray[2][2];
    
    $player = getPlayer($board_num, $turn);
    
    updateDB("UPDATE BOARD
             SET CELLA1='$A1', CELLA2='$A2', CELLA3='$A3',
                 CELLB1='$B1', CELLB2='$B2', CELLB3='$B3',
                 CELLC1='$C1', CELLC2='$C2', CELLC3='$C3',
                 TURN='$player'
             WHERE BOARD_NUM='$board_num'");
}
                       
function win ($array, $symbol) {
    for($i = 0; $i < 3; $i++) {
        if (checkrow($array, $i, $symbol)){
            return true;
			
        }
    }
    for($i = 0; $i < 3; $i++) {
        if (checkCol($array, $i, $symbol)) {
            return true;
        }
    }
    for($i = 0; $i < 3; $i+=2) {
        if (checkDiag($array, $i, $symbol)) {
            return true;
        }
    }
    return false;
}
                       
function checkRow ($array, $row, $symbol) {
    for  ($i = 0; $i < 3; $i++) {
        if ($array[$row][$i] != $symbol) {
            return false;
        }
    }
    return true;
}
                       
function checkCol ($array, $col, $symbol) {
    for  ($i = 0; $i < 3; $i++) {
        if ($array[$i][$col] != $symbol) {
            return false;
        }
    }
    return true;
}
                       
function checkDiag ($array, $col, $symbol) {
    if ($array[1][1] != $symbol || $array[0][$col] != $symbol){
        return false;
    }
    else if ($col == 0 && $array[2][2] != $symbol) {
        return false;
    }
    else if ($col == 2 && $array[2][0] != $symbol) {
        return false;
    }
    else {
        return true;
    }
}

//main game function
function game($board, $gameArray, $numTurns, $turn, $symbol, $isTurn, $cellid, $r, $c) {
    
    //if the current player is allowed to make a move
    //i.e. it is their turn, the total number of turns played is less than 9, the space is "null", and no one has won yet
    if ($isTurn == 1 && $numTurns < 9 && (strcmp($cellid, "N") == 0) && (win($gameArray, $symbol) == false)) {
        
        $gameArray[$r][$c] = $symbol;
                       
					   
		//SELECT `TURN` FROM `board` WHERE `BOARD_NUM`=17 #Fetches User
        if (win($gameArray, $symbol)) {
			$turnUID = $_SESSION['userID'];
			updateDB("UPDATE BOARD SET WINNER='$turnUID' WHERE BOARD_NUM='$board'");
            $message = $symbol." won!";
            $numTurns = 9;
			
        }
        else if (($numTurns += 1) == 9) {
			updateDB("UPDATE BOARD SET WINNER = \"CAT\" WHERE BOARD_NUM='$board'");
            $message = "Cat's game."; //This probably doesn't get displayed for long.
			
			
        }
        else {
             $message = "";
        }
                       
        $newturn = ($turn + 1) % 2; //switch turns
        saveGame($board, $gameArray, $newturn); //save game state in DB
    }
    else {
        $message = "Cannot move.";
    }
    return $message;
}


?>
