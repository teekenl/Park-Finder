<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 9/05/2017
 * Time: 8:22 PM
 */

    $park_result_sql = "SELECT * FROM brisbane_parks WHERE park_name LIKE '%$places%' AND park_suburb LIKE '%$suburb%'";
    $page_count = 0;
    $park_array= array();
    $park_result = $db->query($park_result_sql);

    //defensive programming for coordinates checking
    if($places=="") {
        if (count($coords)!== 2) {
            echo "<script>alert('The coordinates is not valid');window.location.href='search_query.php';</script>";
            exit();
        } else if($coords!="" && !check_valid_coordinates($coords)) {
            echo "<script>alert('The coordinates is not valid');window.location.href='search_query.php';</script>";
            exit();
        }
    }

    // Check if the rating option or getting current location is chosen by user.
    if ($rating == "") {
        if($coords != "") {
            foreach($park_result as $park_result_row) {
                $park_code = $park_result_row['park_code'];
                $park_name = $park_result_row['park_name'];
                include  'get_review_detail.inc';

                // Filter the park with the distance exceeds 5km range
                if(distance_travel($coords[0],$coords[1],$park_result_row['park_latitude'],$park_result_row['park_longtitude']) > 5) {
                    continue;
                }
                $park_array[$page_count][0] = $park_code;
                $park_array[$page_count][1] = $park_result_row['park_id'];
                $park_array[$page_count][2] = $review_level;
                $park_array[$page_count][3] = $review_user_rating;
                $park_array[$page_count][4] = $review_row_count;
                $page_count++;
            }

        } else {
            $page_count = $park_result->rowCount();
        }

    } else {
        foreach ($park_result as $park_result_row) {
            $park_code = $park_result_row['park_code'];
            $park_name = $park_result_row['park_name'];
            include  'get_review_detail.inc';
            if($coords != "") {
                if(distance_travel($coords[0],$coords[1],$park_result_row['park_latitude'],$park_result_row['park_longtitude']) > 5) {
                    continue;
                }
            }
            if (intval($review_user_rating) >= intval($rating)) {
                $park_array[$page_count][0] = $park_code;
                $park_array[$page_count][1] = $park_result_row['park_id'];
                $park_array[$page_count][2] = $review_level;
                $park_array[$page_count][3] = $review_user_rating;
                $park_array[$page_count][4] = $review_row_count;
                $page_count++;
            }

        }
    }

    if ($page_count <= 0 ) {
        echo "<div style='font-size:2.0em;position:absolute;left:50%'>No result</div>";
        echo "<script>document.getElementById('loader').style.display = \"none\";</script>";
        exit;
    }


    // Helper function to check the coordinates is valid or not
    function check_valid_coordinates($coordinates) {
        $re = '`^(?<latitude>[-]?[0-8]?[0-9]\.\d+|[-]?90\.0+?)(?<delimeter>.)(?<longitude>[-]?1[0-7][0-9]\.\d+|[-]?[0-9]?[0-9]\.\d+|[-]?180\.0+?)$`';

        if( preg_match($re, (string)$coordinates[0].$coordinates[1], $matches, PREG_OFFSET_CAPTURE, 0)) {
            return true;
        } else{
            return false;
        }

    }
?>