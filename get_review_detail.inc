<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 10/05/2017
 * Time: 4:47 PM
 */
    include 'db_connect.inc';
    $sql = "SELECT * FROM user_review WHERE review_parkCode ='$park_code' AND review_park='$park_name' ORDER BY user_commentDate DESC ";
    $result = $db->query($sql);

    $review_row_count = $result ? $result ->rowCount():0;
    $review_user_rating = 0;
    $review_level = "";
    $review_percentage_rate = 93;

    if ($review_row_count > 0) {
        $total_rating = 0;
        $total_user = 0;
        $high_rating_user = 0;
        foreach ($result as $rowPark) {
            $user_rating = intval($rowPark['user_rating']);
            if ($user_rating > 2 ) {
                $high_rating_user ++;
            }
            // Calculate the total number of user make review to the park
            $total_user++;
            // Calculate the total rating from list of review.
            $total_rating  += $user_rating;
        }

        // Calculate average or mean of rating of the park
        $review_user_rating = round(floatval($total_rating / $total_user),1);
        $review_percentage_rate  = intval($high_rating_user / $total_user * 100);

        // Return the banner based on the level of average of rating
        if ($review_percentage_rate >= 80) {
            $review_level = "Good";
        } else if ($review_percentage_rate > 60 && $review_percentage_rate < 80) {
            $review_level = "Moderate";
        } else {
            $review_level = "Bad";
        }

        // Return the percentage of customer make the review
        $review_percentage_rate = $review_percentage_rate > 0 ? $review_percentage_rate . "%": "0";

    } else {
        $review_level = "Not available";
        $review_percentage_rate = "";
        $review_user_rating = "0";
    }

?>