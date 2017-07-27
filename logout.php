<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 7/05/2017
 * Time: 4:39 PM
 */
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    if(isset($_SESSION['review_url'])) {
        unset($_SESSION['review_url']);
    }
    session_destroy();

    if (!isset($_SESSION['username'])) {
        echo "<!DOCTYPE html>";
        echo "<html lang=\"en\">";
        echo "<head>";
        echo "<meta charset=\"UTF-8\">";
        echo "<title>Logging Out</title>";
        echo "<link rel=\"icon\" type=\"image/gif\" href=\"img/main_logo.png\" />";
        echo "<link rel=\"stylesheet\" href=\"css/loading.css\"/>";
        echo "</head>";
        echo "<body>";
        echo "<div>You have logged out</div>";
        echo "<div class=\"loader\"></div>";
        echo "<script>window.location.href='signin.php';</script>";
    } else{
        echo "Network error. Please try it again";
    }
?>