<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 7/05/2017
 * Time: 4:41 PM
 */
    // start session and changed the account status
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['lname'])) {
        echo "<div class=\"dropdown-login\">";
        echo "<div id=\"account-status\" class=\"nav-log-in-wrapper\" onclick=\"drop_down()\">My Account";
        echo "&nbsp;&nbsp;<img src=\"img/down-arrow.png\" alt=\"down-arrow-login\" title=\"down-arrow-login\" width=\"10\" height=\"10\" /></div>";
        echo "<div  id=\"main-dropdown\" class=\"dropdown-content\">";
        echo "<a href=\"signin.php\">Log in</a>";
        echo "<a href=\"signup.php\">Register</a>";
        echo "<a href=\"search_query.php\">Search</a></div></div>";
    } else{
        $user = $_SESSION['lname'];
        echo "<div class=\"dropdown-login\">";
        echo "<div id=\"account-status\" class=\"nav-log-in-wrapper\" onclick=\"drop_down()\">$user";
        echo "&nbsp;&nbsp;<img src=\"img/down-arrow.png\" alt=\"down-arrow-login\" title=\"down-arrow-login\" width=\"10\" height=\"10\" /></div>";
        echo "<div  id=\"main-dropdown\" class=\"dropdown-content\">";
        echo "<a href=\"search_query.php\">Search</a>";
        echo "<a href=\"logout.php\">Log out</a></div></div>";
    }

?>