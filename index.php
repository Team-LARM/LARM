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

        <p>Lorem ipsum dolor sit amet, minim vitae mollis id pro, eros explicari his ei, id nec aeterno docendi. Per assum quodsi integre at, eos te dicta nostro labitur. Pro solet vivendo sensibus ut, quo in porro electram. Vix natum perpetua consulatu an, mea ea oporteat mediocrem erroribus, has an copiosae atomorum interesset. Quo at vocibus insolens. Ut nihil convenire est, cetero hendrerit qui id, purto referrentur ne eam. Te brute omnes neglegentur his.</p>

        <p>Ne libris vivendum tacimates pri, tritani concludaturque ut vix. Qui dicat inermis appellantur ea. Ullum reformidans duo id, in mei oblique volumus. No paulo postea duo. Eu sit labore postulant, case summo facete nam ut, et magna viderer voluptaria his. Duo platonem tincidunt eu, nec an altera accusata scriptorem. Ne pro integre intellegat, meliore suscipiantur voluptatibus mei at.</p>

        <p>Ea assum labore vocibus eos. Sit no minim electram constituto, nihil eligendi ea mei, augue copiosae gloriatur in mel. Scaevola sensibus dignissim id per, eam erant partiendo an, et eos nostro accusata expetendis. Meliore elaboraret eu eos, quo eruditi probatus tincidunt eu. Ea suas discere mnesarchum vis, sed congue nonumes accumsan no, id pri ipsum malorum.</p>

        <p>An facer praesent dignissim usu, nibh percipit similique cu sed. Has denique invidunt incorrupte ad, vis ea prima novum. Ignota laoreet commune vel ut. Sit ad prima euismod.</p>

        <p>Te mei tale dolorem. Alia everti legimus est in. Aeterno quaeque ex vix, vim eu elit iusto malorum. Ex omittantur dissentiet mel. Ne nominavi vivendum molestiae his. Laoreet tibique cu duo.</p>
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
