<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="css/sign-in.css" />
    <link rel="stylesheet" type="text/css" href="css/loading.css" />
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/validation.js" type="text/javascript"></script>
</head>
<body>

    <div class="login-in-wrapper" id="login-state" >
        <form class="login" id="login-state-form" action="search_query.php">

            <ul class="bubble-animation">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>

            <a href="index.php" ><img src="img/main_logo.png" alt="Logo" title="Logo" width="260" height="150"/></a>
            <p class="title">You have logged in. </p>
            <img src="img/user-photo.png" style="z-index:10000; border-radius=50%;" alt="user-photo" title="user-photo" />
            <p style="font-size:1.2em;font-weight:600;"><?php echo isset($_SESSION['username'])? $_SESSION['lname']:"Unknown User";?></p>
            <p style="z-index:100000;"><a href="logout.php">Not you?</a></p>
            <input type="submit" value="Search Park >>" />
        </form>
    </div>

    <div class="login-in-wrapper" id="not-login-state">
        <form class="login" id="not-login-state-form" action="verification.php" onsubmit="return loginValidation();" method="post">
            <ul class="bubble-animation">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>

            <a href="index.php" ><img src="img/main_logo.png" alt="Logo" title="Logo" width="260" height="150"/></a>

            <p class="title">Sign in </p>
            <span style="color:red;z-index:2000;"><?php echo isset($_SESSION['error-login']) ? "The email or password is incorrect": ""; unset($_SESSION['error-login'])?></span>
            <p class="fa fa-user"></p>
            <input type="email" id="username" name="username" placeholder="Email" maxlength="30" autocomplete="off" oninput="checkUsername()"/>
            <span class="error-Message" id="username-error"></span>

            <p class="fa fa-key"></p>
            <input type="password" id="password" name="password" placeholder="Password" maxlength="100"  autocomplete="off" oninput="checkPassword()"/>
            <span class="error-Message" id="password-error"></span>
            <br/>
            <a href="recovery_password.php">Forgot your password?</a>

            <input type="submit" value="Log in" id="log-in-button" />
            <div class="sign-up-wrapper">
                Do not have an account?
                <a href="signup.php">Sign up to Company --> </a>
            </div>

        </form>
        <img class="picture-wrapper" src="img/home_image6.jpg" alt="log-in-scene" title="Sign-in background" />

        <div class="loader"></div>
    </div>
    <?php
        if(isset($_SESSION['username'])){
            echo "<script>document.getElementById('login-state-form').style.visibility='visible';</script>";
            echo "<script>document.getElementById('not-login-state-form').style.visibility='hidden';</script>";
        } else{
            echo "<script>document.getElementById('not-login-state-form').style.visibility='visible';</script>";
            echo "<script>document.getElementById('login-state-form').style.visibility='hidden';</script>";
        }
    ?>
</body>
</html>