<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 9/05/2017
 * Time: 10:40 PM
 */

    // Set pagination link for previous and next page
    $item_page_url = "";
    if(isset($_GET['coords']) and trim($_GET['coords'])!="") {
        // Set pagination link with the coord input
        $coords = urlencode($coords);
        $item_page_url= "coords=".$_GET['coords']."&suburb=$suburb&rating=$rating";
        $item_page_url = $item_page_url;
    } else if(isset($_GET['place'])){
        // Set pagination link with the place input
        $places = urlencode($places);
        $item_page_url= "place=$places&suburb=$suburb&rating=$rating";
        $item_page_url = $item_page_url;
    } else {
        // Defensive programming: if the url is invalid or not properly created.
        echo "<script>alert('The url is invalid');window.location.href='search_query.php';</script>";
    }

    if ($requestedPage == 1) {
        // Set page 1 ,2 and 3 if the initial or requested page is 1
        $next = $requestedPage + 1;
        $nextToPage = $requestedPage + 2;
        if ($next<=$total_page_count) {
            if($nextToPage<=$total_page_count) {
                echo "<div id='pagination'><a class=\"current\" href=\"search.php?$item_page_url\">$requestedPage</a>";
                echo "<a href=\"search.php?$item_page_url&page=$next\">$next</a>";
                echo "<a href=\"search.php?$item_page_url&page=$nextToPage\">$nextToPage</a></div>";
            } else{
                echo "<div id='pagination'><a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a>";
                echo "<a href=\"search.php?$item_page_url&page=$next\">$next</a></div>";
            }
        } else{
            echo "<div id='pagination'><a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a></div>";
        }

    } else if ($requestedPage == $total_page_count) {
        // Set page n-1, n , n+1 if the n is requested page and it is larger 2
        $previous = $requestedPage - 1;
        $previousToPage = $requestedPage - 2;
        if ($previous>0) {
            if($previousToPage>0) {
                echo "<div id='pagination'><a href=\"search.php?$item_page_url&page=$previousToPage\">$previousToPage</a>";
                echo "<a href=\"search.php?$item_page_url&page=$previous\">$previous</a>";
                echo "<a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a></div>";

            } else{
                echo "<div id='pagination'><a href=\"search.php?$item_page_url&page=$previous\">$previous</a>";
                echo "<a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a></div>";
            }
        } else{
            echo "<div id='pagination'><a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a></div>";
        }
    } else {
        // Set page n-2 , n-1 and n if the n is maximum and last of available page
        $previous = $requestedPage - 1;
        $next = $requestedPage + 1;
        echo "<div id='pagination'>";
        if ($previous>0) {
            echo "<a href=\"search.php?$item_page_url&page=$previous\">$previous</a>";
        }

        echo "<a class=\"current\" href=\"search.php?$item_page_url&page=$requestedPage\">$requestedPage</a>";

        if ($next <= $total_page_count) {
            echo "<a href=\"search.php?$item_page_url&page=$next\">$next</a>";
        }
        echo "</div>";
    }

?>

