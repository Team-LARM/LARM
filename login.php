<!DOCTYPE html>

<?php

include 'scripts.php';
$message = "";
$result = array();

if(isset($_SESSION['userID'])) {
    $currentUser = $_SESSION['userID'];
}

if($_SERVER["REQUEST_METHOD"] == "POST") {    
    
    session_start();
    
    if (isset($_SESSION['userID']))
        $message = 'User is already logged in';

    if(!isset($_POST['User_ID'], $_POST['Password']))
        $message = 'Please enter a valid username/password';

    elseif(strlen($_POST['User_ID']) > 20 || strlen($_POST['User_ID']) < 5)
        $message = 'Incorrect length for username';

    elseif(strlen($_POST['Password']) > 20 || strlen($_POST['Password']) < 5)
        $message = 'Incorrect length for password';

    elseif(ctype_alnum($_POST['User_ID']) != true)
        $message = 'Username must be alpha-numeric';

    elseif(ctype_alnum($_POST['Password']) != true)
        $message = 'Password must be alpha-numeric';

    else {
        $larm_username = filter_var($_POST['User_ID'], FILTER_SANITIZE_STRING);
        $larm_password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
        $larm_password = sha1($larm_password); 

        $dbh = connectMySQL();

        try {
            
            $stmt = $dbh->prepare("SELECT ID_Number, User_ID, Password FROM USER WHERE User_ID = :User_ID AND Password = :Password");

            $stmt->bindParam(':User_ID', $larm_username, PDO::PARAM_STR);
            $stmt->bindParam(':Password', $larm_password, PDO::PARAM_STR, 40);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $userID = $result['User_ID'];
            //$userStatus = $result['active'];
                        
            if($userID == false)
                $message = 'Account not on file';
            
            else {
                $_SESSION['userID'] = $userID;
                $message = 'You are now logged in';
            }
        }

        catch(Exception $e) {
            $message = 'We are unable to process your request.  Please contact the webadmin';
        }
    }
    
}

?>

<html>
<head>
    <title>LARM > Login</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
    </head>

<body>
    <div class="pageContainer">
    
    <div class="headerContainer">
        <div class="headerBanner">
            <div class="headerRight">
            
                
                <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>
            </div>
        </div>
        <div class="headerLeft">
            <a href="index.php"><img src="images/LARMGaming.png" alt="LARM Gaming" title="LARM Gaming" width="176" height="240"></a>
            </div>
        </div>
    <div class="twolineAuth">
        <h2>User Login</h2>
            <form method="POST" action="
            <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><label for="User_ID">Username: </label><input type="text" id="User_ID" name="User_ID" value="" maxlength="20" /></p>
                
                <p><label for="Password">Password: <label><input type="Password" id="Password" name="Password" value="" maxlength="20" /></p>
                
                <p><input type="submit" value="&rarr; Login" /></p>  
            </form>
            <p><?php
                    // Message display code and redirect for successful login
                     echo $message; 
                    if ($message == 'You are now logged in')
                        header("Refresh:3; url=gameslanding.php");
                ?></p>
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
