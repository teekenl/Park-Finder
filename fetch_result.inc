<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 7/05/2017
 * Time: 5:35 PM
 */
    include 'db_connect.inc';

    // To check the requested page, set first page as initial page is the page
    // selection is empty
    $requestedPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $item_per_page = 5;
    $first_item = ($requestedPage - 1) * $item_per_page;

    // Validation of input value from search form
    $places = isset($_GET['place']) ? htmlspecialchars($_GET['place']) : "";
    $suburb = isset($_GET['suburb']) ? htmlspecialchars($_GET['suburb']) : "";
    $rating = isset($_GET['rating']) && intval($_GET['rating']) > 0 && intval($_GET['rating'])<=5 ? $_GET['rating'] : "";
    $coords= isset($_GET['coords']) && trim($_GET['coords']) != "" ? explode(",",$_GET['coords']) : "";

    // Show no result image if the user didnt entered any input
    if($places == "" && $suburb == "" && $rating == "" && $coords == "") {
        echo "<div style='font-size:2.0em;position:absolute;left:50%'>No result</div>";
        echo "<script>document.getElementById('loader').style.display = \"none\";</script>";
        exit();
    }
    include 'page_count.inc';
    // Calculate the total number of available of page (Each page would have 5 item)
    $total_page_count = ceil($page_count/$item_per_page);

    // Show no result message if the details are not found
    if($requestedPage>$total_page_count) {
        echo "<div style='font-size:2.0em;position:absolute;left:50%'>No result</div>";
        echo "<script>document.getElementById('loader').style.display = \"none\";</script>";
    } else{
        if (count($park_array) <= 0) {
            // Perform operation here if the users search by places
            $sql = "SELECT * FROM brisbane_parks WHERE park_name LIKE '%$places%' AND park_suburb LIKE '%$suburb%' LIMIT $first_item,$item_per_page";
            $result = $db->query($sql);
            $num_of_row = $result -> rowCount();
            $park_details = array();
            $curr_coordinate = explode(",",current_coord());
            $current_lat = floatval($curr_coordinate[0]);
            $current_lng = floatval($curr_coordinate[1]);
            if($num_of_row>0) {
                $num_item_count = 0;
                foreach ($result as $row) {
                    $park_id = $row['park_id'];
                    $park_code = $row['park_code'];
                    $park_name = $row['park_name'];
                    $park_street = $row['park_street'];
                    $park_suburb = $row['park_suburb'];

                    // Load the data into park array to be used to create marker in google map
                    $park_details[$num_item_count][0] = $park_code;
                    $park_details[$num_item_count][1] = $park_id;
                    $park_details[$num_item_count][2] = $park_name;
                    $park_details[$num_item_count][3] = $park_suburb;
                    $park_details[$num_item_count][4] = $park_street;
                    $park_details[$num_item_count][5] = floatval($row['park_latitude']);
                    $park_details[$num_item_count][6] = floatval($row['park_longtitude']);

                    // Append data in result container in result page
                    include 'get_review_detail.inc';
                    echo "<div class=\"sub-result-container\" itemscope itemtype=\"http://schema.org/Place\">";
                    echo "<div class=\"sub-result-image\">";
                    echo "<img itemprop=\"photo\" src=\"img/park_meme.jpg\" alt=\"Image of Result\" width=\"250\" height=\"200\" title=\"Image of Result\"/></div>";
                    echo "<div class=\"sub-result-details\">";
                    echo "<p class=\"result-places-title\" itemprop=\"name\">$park_name</p>";
                    echo "<p class=\"result-places-rating\">";
                    $rating_round_off = round($review_user_rating);
                    if ($rating_round_off>0) {
                        for ($i=1; $i<=$rating_round_off;$i++) {
                            echo "<span class=\"star-one\"></span>";
                        }
                    } else{
                        echo "No rating";
                    }
                    echo "</p>";
                    echo "<p class=\"result-places-description\"  itemprop=\"address\">$park_street, $park_suburb</p>";
                    if($review_user_rating >=1 ) {
                        echo "<p class=\"result-places-number-review\" itemprop=\"aggregateRating\" itemscope itemtype=\"http://schema.org/AggregateRating\">";
                        echo "$review_level  -  <span itemprop=\"ratingValue\">$review_user_rating</span> /<span itemprop='worstRating' style='visibility: hidden;'>0</span><span itemprop='bestRating'>5</span> (<span itemprop='reviewCount'>$review_row_count</span> reviews)</p></div>";
                    } else{
                        echo "<p class=\"result-places-number-review\">";
                        echo "$review_level  -  <span>$review_user_rating</span> /<span>5</span> (<span>$review_row_count</span> reviews)</p></div>";
                    }
                    if ($review_level == "Good") {
                        echo "<div class=\"sub-result-rating-button\"><p class=\"rating-level-banner\">Good</p>";
                    } else if ($review_level == "Moderate") {
                        echo "<div class=\"sub-result-rating-button\"><p style='background-color: #cccc99' class=\"rating-level-banner\">Moderate</p>";
                    } else if ($review_level == "Bad") {
                        echo "<div class=\"sub-result-rating-button\"><p style='background-color: #c21515' class=\"rating-level-banner\">Bad</p>";
                    } else {
                        echo "<div class=\"sub-result-rating-button\"><p style='background-color:#999999' class=\"rating-level-banner\">Unknown</p>";
                    }

                    echo "<p class='sub-result-distance'>".distance_travel($current_lat,$current_lng,floatval($row['park_latitude']),floatval($row['park_longtitude']))." km from here</p>";
                    echo "<div itemprop=\"geo\" itemscope itemtype=\"http://schema.org/GeoCoordinates\">";
                    echo "<span itemprop=\"latitude\" content=\"$row[park_latitude]\" ></span>";
                    echo "<span itemprop=\"longitude\" content=\"$row[park_longtitude]\" ></span></div>";
                    echo "<button type=\"button\" onclick=\"window.location.href='review.php?park_code=$park_code&park_id=$park_id'\">View</button></div></div>";

                    // Count the total number of available park
                    $num_item_count ++;
                }

                // Initialize the marker in google map
                echo "<script>initMap(".json_encode($park_details).")</script>";

            } else{
                // No result message if the details is not found in database
                echo "<div style='font-size:2.0em;position:absolute;left:50%'>No result</div>";
                echo "<script>document.getElementById('loader').style.display = \"none\";</script>";
            }
        } else {
            // Perform operation here if user search by current location
            $park_details = array();
            $curr_coordinate = explode(",",current_coord());
            $current_lat = floatval($curr_coordinate[0]);
            $current_lng = floatval($curr_coordinate[1]);
            $num_item_count = 0;

            for ($i = $first_item; $i<count($park_array); $i++) {
                $code_park = $park_array[$i][0];
                $id_park = $park_array[$i][1];
                $level = $park_array[$i][2];
                $user_rating = $park_array[$i][3];
                $number_review = $park_array[$i][4];
                if($num_item_count<5) {
                    $sql = "SELECT * FROM brisbane_parks WHERE park_id = '$id_park' AND park_code = '$code_park'";
                    $result = $db->query($sql);

                    foreach ($result as $row) {
                        // Load every single park detail into array to be used in google map
                        // initializaiton
                        $park_details[$num_item_count][0] = $row['park_code'];
                        $park_details[$num_item_count][1] = $row['park_id'];
                        $park_details[$num_item_count][2] = $row['park_name'];
                        $park_details[$num_item_count][3] = $row['park_suburb'];
                        $park_details[$num_item_count][4] = $row['park_street'];
                        $park_details[$num_item_count][5] = floatval($row['park_latitude']);
                        $park_details[$num_item_count][6] = floatval($row['park_longtitude']);

                        // Append data into result container in the result (search) page
                        echo "<div class=\"sub-result-container\"  itemscope itemtype=\"http://schema.org/Place\">";
                        echo "<div class=\"sub-result-image\">";
                        echo "<img itemprop=\"photo\" src=\"img/park_meme.jpg\" alt=\"Image of Result\" width=\"250\" height=\"200\" title=\"Image of Result\"/></div>";
                        echo "<div class=\"sub-result-details\">";
                        echo "<p class=\"result-places-title\" itemprop=\"name\">$row[park_name]</p>";
                        echo "<p class=\"result-places-rating\">";
                        $rating_round_off = round($user_rating);
                        if ($rating_round_off>0) {
                            for ($star=1; $star<=$rating_round_off;$star++) {
                                echo "<span class=\"star-one\"></span>";
                            }
                        } else{
                            echo "No rating";
                        }
                        echo "</p>";
                        echo "<p class=\"result-places-description\" itemprop=\"address\">$row[park_street], $row[park_suburb]</p>";
                        if ($user_rating >= 1) {
                            echo "<p class=\"result-places-number-review\"  itemprop=\"aggregateRating\" itemscope itemtype=\"http://schema.org/AggregateRating\">";
                            echo "$level  -  <span itemprop=\"ratingValue\">$user_rating</span> /<span itemprop='bestRating'>5</span> (<span itemprop='reviewCount'>$number_review</span> reviews)</p></div>";
                        } else{
                            echo "<p class=\"result-places-number-review\">";
                            echo "$level  -  <span>$user_rating</span> /<span>5</span> (<span>$number_review</span> reviews)</p></div>";
                        }
                        if ($park_array[$i][2] == "Good") {
                            echo "<div class=\"sub-result-rating-button\"><p class=\"rating-level-banner\">Good</p>";
                        } else if ($park_array[$i][2] == "Moderate") {
                            echo "<div class=\"sub-result-rating-button\"><p style='background-color: #cccc99' class=\"rating-level-banner\">Moderate</p>";
                        } else if ($park_array[$i][2] == "Bad") {
                            echo "<div class=\"sub-result-rating-button\"><p style='background-color: #c21515' class=\"rating-level-banner\">Bad</p>";
                        } else {
                            echo "<div class=\"sub-result-rating-button\"><p style='background-color:#999999' class=\"rating-level-banner\">Unknown</p>";
                        }

                        echo "<p class='sub-result-distance'>".distance_travel($current_lat,$current_lng,floatval($row['park_latitude']),floatval($row['park_longtitude']))." km from here</p>";
                        echo "<div itemprop=\"geo\" itemscope itemtype=\"http://schema.org/GeoCoordinates\">";
                        echo "<span itemprop=\"latitude\" content=\"$row[park_latitude]\" ></span>";
                        echo "<span itemprop=\"longitude\" content=\"$row[park_longtitude]\" ></span></div>";
                        echo "<button type=\"button\" onclick=\"window.location.href='review.php?park_code=$row[park_code]&park_id=$row[park_id]'\">View</button></div></div>";

                        // Count the total number of available park
                        $num_item_count++;
                    }
                }
                // Initialize the marker in the google map
                echo "<script>initMap(".json_encode($park_details).")</script>";
            }
        }
    }

    // Helper function to calculate the distance between source and destination point
    function distance_travel($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo){
        $Radius = 6371;
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $Radius,1);
    }

    // Helper function to get the current coordinates of user
    function current_coord(){
        $ip  = file_get_contents("http://ipecho.net/plain");
        $url = "http://freegeoip.net/json/$ip";
        $ch  = curl_init();
        $lat = 0;
        $lon = 0;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data) {
            $location = json_decode($data);

            $lat = $location->latitude;
            $lon = $location->longitude;
        }

        return strval($lat) . "," . strval($lon);
    }

?>