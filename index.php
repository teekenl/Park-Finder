<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="Brisbane,Brisbane Park, Brisbane Park Locator">
    <meta name="author" content="Ken&Leong">
    <meta name="description" content="Brisbane Park Locator. Your incredible journey begins here">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/imageloader.js" type="text/javascript"></script>
    <script src="js/validation.js" type="text/javascript"></script>
    <script src="js/responsive.js" type="text/javascript"></script>
</head>
<body onload="startImageTimer()">

    <header>
        <div id="menu" class="menuWrapper">
            <a><img id="main-picture" src="img/main_logo.png" alt="Hello" title="Hello" width="100" height="60"/></a>
            <a class="content" href="#maincontent">Home</a>
            <a class="content" href="#feature">Feature</a>
            <a class="content" href="#contact-us">Contact Us</a>
            <a class="content" href="search_query.php">Search</a>
            <a class="content" href="signin.php">Sign in</a>
            <a href="javascript:void(0);" style="font-size:15px;" id="menu-content-close" class="icon" onclick="navigationFunction()">&#9776;</a>
            <button onclick="window.location.href='signin.php'" class="button-sign-in-button">
                <?php
                session_start();
                echo isset($_SESSION['username']) ? $_SESSION['lname']: "Sign in";
                ?>
            </button>
        </div>
    </header>

    <div class="wrapper">
        <img id="image-elem" src="img/home_image5.jpg" alt="image1"/>
    </div>

    <div class="main-content2" ></div>
    <div id="maincontent" class="main-content">
        <h1>Brissy's Park Locator</h1>
        <p>Search anywhere, anytime</p>
        <button class="button-learn-more" onclick="window.location.href='search_query.php'">Search</button>
    </div>

    <script type="text/javascript">
        function Scroll(){
            var top = document.getElementById('menu');
            var ypos = window.pageYOffset;
            if(ypos> 10) {
                top.style.backgroundColor = "rgba(0,0,0,1.0)";
                top.style.height = "70px";
            }
            else {
                top.style.backgroundColor = "rgba(0,0,0,0.0)";
                top.style.height = "auto";
            }
        }
        window.addEventListener("scroll", Scroll);
    </script>

    <div id="feature">
        <div id="feature-background-picture"></div>
        <div id="feature-background-overlay">
            <h1 style="text-align: center; font-size: 65px">Feature</h1>
            <div id="search-benefit-wrapper">
                <div id="feature-search-picture">
                    <img src="img/feature-search.png" alt="search-icon" title="Icon Image"/>
                </div>
                <p style="font-size: 2.0em">Search anywhere, anytime</p>
                <p style="font-size:1.2em; width: 70%">Our website provides customer with flexible place search engine. With the flexible and responsive search,
                    customer able to explore more exciting places.
                </p>
            </div>
            <div id="review-benefit-wrapper">
                <div id="feature-review-picture">
                    <img src="img/feature-review.png" alt="review-icon" title="Icon Image" />
                </div>
                <p style="font-size: 2.0em"> Make review or feedback</p>
                <p style="font-size: 1.2em; width: 80%"> Other than that, users able to commit any feedback or comment for particular places. Additionally,
                    list of review of places are accessible for users which give better understanding and idea.
                </p>
            </div>
        </div>
    </div>

    <div id="contact-us">
        <div id="background-picture"></div>
        <div id="background-overlay">
            <h1 id="contact-us-title">Contact us</h1>
            <p id="contact-us-description">We love to hear from your feedback, We're here to help you </p>
        </div>

        <div id="contact-us-wrapper">
            <form id="contact-us-form" action="index.php" method="post" onsubmit="return contact_us_validation();">
                <div id="first-row">
                    <p style="text-align: center; font-size:1.3em">Having a problem? Dont worry.</p>
                    <input id="comment-firstname" name="contact_fname" type="text" placeholder="First Name *" oninput="checkCommentFirstName()" />
                    <input id="comment-lastname" name="contact_lname" type="text" placeholder="Last Name *" oninput="checkCommentLastName()" />
                </div>
                <input type="email" id="comment_email" name="contact_email" placeholder="Email *" oninput="checkCommentEmail()"/>
                <textarea rows="9" cols="70" id="contact_comment" name="contact_comment" placeholder="Comment *" oninput="checkCommentInput()" ></textarea>
                <input type="submit" id="submitcomment" value="Submit" />
            </form>
        </div>
    </div>

    <?php
    include 'footer.inc';
    ?>
    <?php
    $contact_email = isset($_POST['contact_email']) && trim($_POST['contact_email'])!="" ? $_POST['contact_email'] : "";
    if($contact_email != "" ) {
        include 'contact_mail_sending.inc';
    }
    ?>
</body>
</html>