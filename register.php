<!DOCTYPE html>

<?php
    
    session_start();
    include 'scripts.php';
    $message = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['form_token'] != $_SESSION['form_token'])
        $message = 'Invalid form submission';
 
    elseif (!isset($_POST['User_ID'], $_POST['Password'], $_POST['form_token']))
        $message = 'Please enter a valid username and password';

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

            $stmt = $dbh->prepare("INSERT INTO USER (User_ID, Password) VALUES (:User_ID, :Password)");

            $stmt->bindParam(':User_ID', $larm_username, PDO::PARAM_STR);
            $stmt->bindParam(':Password', $larm_password, PDO::PARAM_STR, 40);
            $stmt->execute();

            unset($_SESSION['form_token']);
            $message = 'Registration Complete!';
            $_SESSION['userID'] = $_POST['User_ID'];
        }

        catch(Exception $e) {
            if($e->getCode() == 23000)
                $message = 'Username already exists';
            else
                $message = 'We are unable to process your request.  Please contact the webadmin';
        }    
    }
}

?>

<html>
<head>
    <title>LARM > Register</title>
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
        <h1>Register to play!</h1>
        <h4>- Create a username/password 5-20 alphanumeric characters in length -</h4>
        <br>
        <?php 
            // set form token
            $form_token = md5(uniqid('auth', true));
            // set session form token
            $_SESSION['form_token'] = $form_token; ?>
        
        <form method="POST" action="
            <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><label for="User_ID">Username: </label><input type="text" id="User_ID" name="User_ID" value="" maxlength="20" /></p>
                
                <p><label for="Password">Password: </label><input type="Password" id="Password" name="Password" value="" maxlength="20" /></p>
                
                <p><input type="hidden" name="form_token" value="<?php echo $form_token; ?>" /><input type="submit" value="&rarr; Register" /></p>
            </form>
            <p><?php echo $message;
            if($message == "Registration Complete!")
                header("Refresh:3; url=gameslanding.php");
                ?>
            </p>
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
