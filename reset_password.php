<?php
    session_start();
    if(isset($_SESSION['username'])) {
        echo "<script>alert('You have logged in');</script>";
        echo "<script>window.location.href='signin.php'</script>";
    }
    $oldtimestamp = isset($_GET['timestamp']) ? $_GET['timestamp']: "";
    if ($oldtimestamp!="") {
        $newtimestamp = time();
        $different_in_min = ($newtimestamp - intval($oldtimestamp)) / (60*60);

        if ($different_in_min <= 1 and $different_in_min > 0) {
            // Nothing here
        } else {
            echo "<script>alert('The Password Reset URL has been expired');window.location.href='recovery_password.php'</script>";
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="css/dropdown.css" type="text/css" />
    <link rel="stylesheet" href="css/reset_pwd.css" type="text/css"/>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/dropdown.js" type="text/javascript"></script>
    <script src="js/password_reset.js" type="text/javascript"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div id="menu">
            <a href="index.php"><img id="main-picture" src="img/main_logo.png" alt="Park Photo" title="Park Photo" width="60" height="40"/></a>
            <?php
            include 'session_status.inc';
            ?>
        </div>
    </header>

    <div id="nav-pwd-reset-wrapper">
        <form action="reset_password.php" method="post" onsubmit="return reset_password_validation();">
            <h2>Password Reset for <?php echo isset($_GET['recovery_email']) ? $_GET['recovery_email']:(isset($_POST['recovery_email']) ? $_POST['recovery_email'] : ""); ?></h2>
            <input type="hidden" name="recovery_user_id" value="<?php echo isset($_GET['recovery_user_id'])? $_GET['recovery_user_id']:(isset($_POST['recovery_user_id']) ? $_POST['recovery_user_id']:"");?>"/>
            <input type="hidden" name="recovery_email" value="<?php echo isset($_GET['recovery_email']) ? $_GET['recovery_email']:(isset($_POST['recovery_email']) ? $_POST['recovery_email']:""); ?>"/>
            <label for="reset_password">New Password *</label><br/>
            <span id="error-reset-message"></span><br/>
            <input id="reset_password" name="password-reset" type="password" oninput="check_reset_password()" /><br/>
            <label for="reset_confirm_password">Confirm Password *</label><br/>
            <span id="error-reset-confirm-message"></span><br/>
            <input id="reset_confirm_password" type="password" name="confirm-password-reset" oninput="check_confirm_reset_password()" >
            <input type="submit" value="Confirm" id="update_reset_password" />
        </form>
    </div>

    <div id="nav-pwd-reset-success-wrapper">
        <div id="nav-pwd-reset-success-content">
            <h2>The password has been reset successfully.</h2>
            <p>Sign in now? </p>
        </div>
        <form action="signin.php" method="post">
            <input type="submit" value="Sign in">
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.inc' ?>
</body>
</html>

<?php
    include 'db_connect.inc';
    $recovery_user_id = isset($_POST['recovery_user_id']) ? intval($_POST['recovery_user_id']) : "";
    $recovery_email = isset($_POST['recovery_email']) ? htmlspecialchars($_POST ['recovery_email']): "";
    $confirm_password = isset($_POST['confirm-password-reset'])? md5($_POST['confirm-password-reset']): "";
    if($recovery_email!="" and $confirm_password!="" and $recovery_user_id!=""){
        $sql = "UPDATE user_details SET user_password ='$confirm_password' WHERE user_email='$recovery_email' AND user_id='$recovery_user_id'";
        if($db->query($sql)) {
            echo "<script>document.getElementById('nav-pwd-reset-wrapper').style.display='none';</script>";
            echo "<script>document.getElementById('nav-pwd-reset-success-wrapper').style.display='block';</script>";
        } else{
            echo "<script>alert('The user email or id is empty or incorrect');</script>";
        }
    }
?>