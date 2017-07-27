<?php
    session_start();
    if(isset($_SESSION['username'])) {
        echo "<script>alert('You have logged in');</script>";
        echo "<script>window.location.href='signin.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" type="text/css" href="css/sign-up.css" />
    <link rel="stylesheet" type="text/css" href="css/loading.css" />
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script type="text/javascript" src="js/validation.js"></script>
    <script>
        function checkUnknownChar(e){
            e.value = e.value.replace(/[A-za-z`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
        }
    </script>
    <!-- Retrieve all used email from database used for email duplication checking -->
    <?php
    session_start();
    unset($_SESSION['error-login']);
    include 'db_connect.inc';
    $sql = "SELECT * FROM user_details";
    $result = $db->query($sql);
    $list_email = array();
    $count = 0;
    if($result) {
        foreach($result as $row) {
            $list_email[$count] = $row['user_email'];
            $count++;
        }
    }

    echo "<script>emailValidation.emailLoad(".json_encode($list_email).")</script>";
    ?>
</head>
<body>
    <div class="register-wrapper">
        <form id="sign-up" action="validation.php" method="post" onsubmit="return signupValidation();">
            <a href="index.php" ><img style="margin:20px 0 0 58px;" src="img/main_logo.png" alt="Logo" title="Logo" width="260" height="150"/></a>

            <p class="title">Sign Up</p><br/><br/>
            <span class="error-Message" id="error-user-name-message"></span><br/>
            <div id="user-first-last">
                <input id="firstname" name="firstname" maxlength="20" type="text" placeholder="First Name *" autocomplete="off" oninput="checkFirstName()" />
                <input id="lastname" name="lastname" maxlength="20" type="text" placeholder="Last Name *" autocomplete="off" oninput="checkLastName()"/>
            </div>
            <label for="sign-up-birth-date"></label><br/>
            <span class="error-Message" id="error-birth-date-message"></span><br/>
            <input id="sign-up-birth-date" name="sign-up-birth-date" type="date" oninput="checkBirthDate()"/>

            <span class="error-Message" id="error-phone-message"></span><br/>
            <input id="sign-up-number" name="sign-up-contactNumber" type="tel" placeholder="Phone Number *" maxlength="10"  oninput="checkPhoneNumber(); checkUnknownChar(this);" />

            <span class="error-Message" id="error-sign-up-email-message"></span><br/>
            <input id="sign-up-email" name="sign-up-email" maxlength="30" type="email" placeholder="Your Hotmail *" autocomplete="off" oninput="checkHotmail()"/>

            <span class="error-Message" id="error-sign-up-password-message"></span><br/>
            <input id="sign-up-password" name="sign-up-password" maxlength="100" type="password" placeholder="Password *" autocomplete="off" oninput="checkNewPassword()"/>

            <span class="error-Message" id="error-sign-up-confirm-password-message"></span><br/>
            <input id="sign-up-confirmPassword" name="sign-up-confirmPassword" maxlength="100" type="password" placeholder="Confirm Password" oninput="checkMatchPassword()"/>
            <input type="submit" value="Sign up" id="sign-up-button"/>
            <div class="sign-in-wrapper">
                Already have an account?
                <a href="signin.php">Sign in to Company --> </a>
            </div>

        </form>

        <img class="picture-wrapper" src="img/home_image7.jpg" alt="log-in-scene" title="Sign-in background" />

    </div>
</body>
</html>