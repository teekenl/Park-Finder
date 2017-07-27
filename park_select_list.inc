<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 10/05/2017
 * Time: 7:36 PM
 */

    include 'db_connect.inc';

    $sql = "SELECT * FROM brisbane_parks";
    $result = $db->query($sql);
    $r_count = $result ->rowCount();
    $suburb_option_list = "";
    $selected_suburb = "";
    if($r_count) {
        foreach ($result as $row) {
            $selected = isset($_GET['suburb']) && $_GET['suburb'] == $row['park_suburb'] ? "selected" : "";
            if ($selected == "selected") {
                $selected_suburb = $row['park_suburb'];
            }
            $suburb_option_list .= "<option value='$row[park_suburb]'>$row[park_suburb]</option>";
        }
    } else {
        echo "The database connection is lost";
    }
?>