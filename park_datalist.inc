<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 10/05/2017
 * Time: 5:50 PM
 */
    include 'db_connect.inc';

    $sql = "SELECT * FROM brisbane_parks";
    $result = $db->query($sql);
    $r_count = $result ->rowCount();
    $park_place_list = "";
    $park_suburb_list = "";
    if($r_count) {
        foreach ($result as $row) {
            // Load every data value into autocomplete datalist in search box
            $park_place_list .= "<option value=\"$row[park_name]\">";
            $park_suburb_list .= "<option value=\"$row[park_suburb]\">";
        }
    } else {
        echo "The database connection is lost";
    }
?>