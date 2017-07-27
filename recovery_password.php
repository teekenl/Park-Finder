<?php
    session_start();
    if(isset($_SESSION['username'])) {
        echo "<script>alert('You have logged in');</script>";
        echo "<script>window.location.href='signin.php'</script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="css/dropdown.css" type="text/css" />
    <link rel="stylesheet" href="css/recovery_pwd.css" type="text/css"/>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/dropdown.js" type="text/javascript"></script>
    <script src="js/password_recovery.js" type="text/javascript"></script>
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

    <!-- Invalid User Modal -->
    <div id="invalid-user-Modal" class="invalid-user-modal">
        <!-- Modal content -->
        <div class="user-modal-content">
            <img src="img/id_not_verified.png" alt="invalid-user">
            <p>No such user</p>
            <button id="invalid-user-modal-close" onclick="user_modal_close(this)">Okay</button>
        </div>
    </div>
    <!-- Valid User Modal -->
    <div id="valid-user-Modal" class="valid-user-modal">
        <!-- Modal content -->
        <div class="user-modal-content">
            <img src="img/id_verified.png" alt="valid-user">
            <p>An email has been sent.</p>
            <button id="valid-user-modal-close" onclick="user_modal_close(this)">Okay</button>
        </div>
    </div>

    <div id="nav-pwd-recovery-wrapper">
        <form action="recovery_password.php" method="get" onsubmit="return password_validation();">
            <h1>Password Recovery</h1>
            <label for="recovery_email">Email</label><br/>
            <span id="error-recovery-message"></span><br/>
            <input id="recovery_email" name="recovery-email" type="email" oninput="checkResetPasswordEmail()" /><br/>
            <input type="submit" value="Get Password Reset Link" id="get_password" />
        </form>
    </div>

    <div id="nav-pwd-recovery-wrapper2">
        <form action="recovery_password.php" method="get">
            <input type="hidden" id='recovery_email_resend' name="recovery-email"
                value="<?php
                    echo isset($_GET['recovery-email']) ? $_GET['recovery-email'] : "";
                ?>">
            <h1>A password reset link has been sent to your email</h1>
            <p style="font-weight: 600"> Not received it? </p>
            <input type="submit" id="get_password_resend" value="Resend"/>
        </form>
    </div>
    <?php
        $recovery_email = isset($_GET['recovery-email']) && trim($_GET['recovery-email'])!="" ? $_GET['recovery-email'] : "";
        if($recovery_email != "" ) {
            $recovery_email = htmlspecialchars($recovery_email);
            include 'mail_sending.inc';
        }
    ?>

    <!-- Footer -->
    <?php include 'footer.inc'?>

</body>
</html>
