<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 9/05/2017
 * Time: 10:46 PM
 */
    include 'db_connect.inc';

    if(!isset($park_code) && !isset($park_id)) {
        echo "Error";
        exit;
    }
    $park_id = intval($park_id);
    $sql = "SELECT * FROM brisbane_parks WHERE park_code = '$park_code' AND park_id = '$park_id'";
    $result = $db->query($sql);
    $park_name = "";
    $park_street= "";
    $park_suburb = "";
    $lat = "";
    $lng = "";
    $curr_coordinate = explode(",",current_coord());
    $current_lat = floatval($curr_coordinate[0]);
    $current_lng = floatval($curr_coordinate[1]);

    $park_info = array();
    $rowCount = $result->rowCount();
    if($rowCount>0) {
        foreach($result as $row) {
            // Load the park detail into array if it is found. The data is being used
            // to create marker on google map
            $park_name = $row['park_name'];
            $park_street = $row['park_street'];
            $park_suburb = $row['park_suburb'];
            $lat = $row['park_latitude'];
            $lng = $row['park_longtitude'];
            $park_info[0] = $park_id;
            $park_info[1]  = $park_name;
            $park_info[2] = $park_street;
            $park_info[3]  = $park_suburb;
            $park_info[4] = floatval($lat);
            $park_info[5]  = floatval($lng);
            $distance = distance_travel($current_lat,$current_lng,$park_info[4],$park_info[5]);
        }

        // Initialize google map with location of park
        echo "<script>initMap2(".json_encode($park_info).")</script>";

    } else {
        // Prompt message if the park is not found
        echo "<div style='font-size:1.2em;position:absolute;top:40%;left:45%;'>The Park is not found.";
        echo "<br/><br/>&nbsp;&nbsp;&nbsp;<a href='search_query.php'>Go back to Search</a></div>";
        exit;
    }

    // Helper function to calculate the distance between source and destination
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

    // Helper function to access current coordinates of user.
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