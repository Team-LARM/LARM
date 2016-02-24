<!DOCTYPE html>

<!-- PHP implementation for different CEFNS site/database.  We can change this as necessary but this includes much of the injection and string verification-->

<!--Sanitization of input strings-->
<!--sha1 encryption of passwords for database storage-->
<!--uses separate script/PDO connection standard for database-->
<!--catches exceptions and posts back to itself, redirects user to their own page if login was successful-->

<?php /*

    include 'mysql_scripts.php';
    
if($_SERVER["REQUEST_METHOD"] != "POST") {
    // user session begins
    session_start();
    $message = "";

    // set form token
    $form_token = md5(uniqid('auth', true));

    // set session form token
    $_SESSION['form_token'] = $form_token;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_POST['incub_username'], $_POST['incub_password'], $_POST['form_token']))
        $message = 'Please enter a valid username and password';

    elseif($_POST['form_token'] != $_SESSION['form_token'])
        $message = 'Invalid form submission';

    elseif(strlen($_POST['incub_username']) > 20 || strlen($_POST['incub_username']) < 5)
        $message = 'Incorrect length for username';

    elseif(strlen($_POST['incub_password']) > 20 || strlen($_POST['incub_password']) < 5)
        $message = 'Incorrect length for password';

    elseif(ctype_alnum($_POST['incub_username']) != true)
        $message = 'Username must be alpha-numeric';

    elseif(ctype_alnum($_POST['incub_password']) != true)
        $message = 'Password must be alpha-numeric';

    else {
        
        $incub_username = filter_var($_POST['incub_username'], FILTER_SANITIZE_STRING);
        $incub_password = filter_var($_POST['incub_password'], FILTER_SANITIZE_STRING);
        $incub_password = sha1($incub_password); 

        $dbh = connectMySQL();
        
        try {

            $stmt = $dbh->prepare("INSERT INTO incub_users (incub_username, incub_password) VALUES (:incub_username, :incub_password)");

            $stmt->bindParam(':incub_username', $incub_username, PDO::PARAM_STR);
            $stmt->bindParam(':incub_password', $incub_password, PDO::PARAM_STR, 40);
            $stmt->execute();

            unset($_SESSION['form_token']);
            $message = 'Registration Complete!';
        }

        catch(Exception $e) {
            if($e->getCode() == 23000)
                $message = 'Username already exists';
            else
                $message = 'We are unable to process your request.  Please contact the webadmin';
        }    
    }
}

*/?>

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
    <h2>Register to become a site user!</h2>
            <form method="POST" action="
            <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><label for="incub_username">Username: </label><input type="text" id="incub_username" name="incub_username" value="" maxlength="20" /></p>
                
                <p><label for="incub_password">Password: </label><input type="password" id="incub_password" name="incub_password" value="" maxlength="20" /></p>
                
                <p><input type="hidden" name="form_token" value="<?php echo $form_token; ?>" /><input type="submit" value="&rarr; Register" /></p>
            </form>
            <p><?/*php echo $message;
            if($message == "Registration Complete!")
                header("Refresh:3; url=index.php");
                */?>
            </p>    
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
