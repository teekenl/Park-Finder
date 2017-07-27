
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading</title>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <link rel="stylesheet" href="css/loading.css"/>
    <link rel="stylesheet" href="css/dropdown.css"/>
</head>
<body>
<div class="loader"></div>

</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 10/05/2017
 * Time: 1:31 AM
 */
    include 'db_connect.inc';
    session_start();
    date_default_timezone_set("Australia/Brisbane");

    // Initialization of variable based on comment made by user
    $regDate = date('Y-m-d H:i:s',time());
    $park_code = isset($_POST['parkcode'])? $_POST['parkcode'] : "";
    $park_name = isset($_POST['parkname'])? $_POST['parkname'] : "";
    $park_id = isset($_POST['parkid']) ? $_POST['parkid'] : "";
    $userComment =  isset($_POST['user-comment']) ? htmlspecialchars($_POST['user-comment']): "";
    $userHeadline =  isset($_POST['user-headline']) ? htmlspecialchars($_POST['user-headline']): "";
    $userRating =  isset($_POST['user-rating']) ? $_POST['user-rating']: "0";

    // defensive programming: check if sign-in status and detail of user
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
        echo "<script>alert('Please login to make review')</script>";
        echo "<script>window.location.href='signin.php';</script>";
    }

    // defensive programming: check if the value has been declared and assigned with right value
    if($userComment!="" and $userHeadline!="" and $userRating!="") {
        $sql = $db->prepare("INSERT INTO user_review (review_id,review_parkCode,review_park,
                          user_id,user_name,user_headline,user_rating,user_commentDate,user_comment) VALUES (NULL,
                          :review_parkCode,:review_park,:user_id,:user_name,:user_headline,:user_rating,:user_commentDate,:user_comment)");
        $sql -> bindParam(':review_parkCode',$park_code);
        $sql -> bindParam(':review_park',$park_name);
        $sql -> bindParam(':user_id',$_SESSION['user_id']);
        $sql -> bindParam (':user_name',$_SESSION['username']);
        $sql -> bindParam(':user_headline',$userHeadline);
        $sql -> bindParam(':user_rating',$userRating);
        $sql -> bindParam(':user_commentDate',$regDate);
        $sql -> bindParam(':user_comment',$userComment);

        if($sql->execute()) {
            // Prompt the successful message if the comment has been added
            echo "<script>window.location.href='review.php?park_code=$park_code&park_id=$park_id';</script>";
        } else {
            // Prompt the error message if network connection is weak or invalid
            echo "The database connection has been lost.";
        }

    } else{
        // Prompt the message if the url is entered correclty
        echo "<script>alert('The park code or id is not received');window.location.href='search_query.php';</script>";
    }
?>