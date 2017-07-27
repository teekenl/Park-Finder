<?php
    if (!isset($_GET['place']) and !isset($_GET['suburb']) and !isset($_GET['rating']) and
            !isset($_GET['coords'])) {
        echo "<script>window.location.href='search_query.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="css/dropdown.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/search.css" />
    <link rel="stylesheet" type="text/css" href="css/loading.css"/>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/dropdown.js" type="text/javascript"></script>
    <script src="js/searchLoad.js" type="text/javascript"></script>
    <script src="js/map.js" type="text/javascript"></script>
    <script src="js/geolocation.js" type="text/javascript"></script>
</head>
<body>
    <div id="loader" style="z-index: 9999;" class="loader_2"></div>
    <!-- Header -->
    <header>
        <div id="menu">
            <a href="index.php"><img id="main-picture" src="img/main_logo.png" alt="Park Photo" title="Park Photo" width="60" height="40"/></a>
            <?php
            include 'session_status.inc';
            ?>
        </div>
    </header>

    <div id="nav-background-wrapper"></div>
    <div id="search-wrapper">
        <form action="loading.php" id="search-location-places" method="get">
            <?php include 'park_datalist.inc' ?>
            <input list="park_place" type="text" id="search-text" name="place" placeholder="e.g. Brisbane City"
                   value = "<?php
                        if (isset($_GET['place'])) {
                            echo $_GET['place'];
                        } else if(isset($_GET['coords'])) {
                            echo  htmlspecialchars("Current Location");
                        }
                   ?>"
                   autocomplete="off" onfocus="change_location_search(this);">
            <datalist id="park_place">
                <?php
                    echo $park_place_list;
                ?>
            </datalist>
            <input type="hidden" id="suburb" name="suburb"
                   value="<?php
                       if (isset($_GET['suburb'])) {
                           echo htmlspecialchars($_GET['suburb']);
                       }
                   ?>"/>
            <input type="hidden" id="rating" name="rating"
                   value="<?php
                   if (isset($_GET['rating'])) {
                       echo htmlspecialchars($_GET['rating']);
                   }
                   ?>"/>
            <input type="hidden" name="currentLat" id="currentLat_search"
                   value="<?php
                   $coordinates= isset($_GET['coords']) && trim($_GET['coords']) != "" ? explode(",",$_GET['coords']) : "";
                       if($coordinates != "") {
                           echo htmlspecialchars($coordinates[0]);
                       }
                   ?>"/>
            <input type="hidden" name="currentLng" id="currentLng_search"
                   value="<?php
                       if($coordinates != "") {
                           echo htmlspecialchars($coordinates[1]);
                       }
                   ?>"/>
            <button id="submit-search-button" type="submit">Search</button>
        </form>
    </div>


    <div id="result-title-count">
    </div>


    <div id="advancedSearch">
        <div id="headerSearch">Need more search option?</div>
        <div id="ratingSearch">
            <div id="titleRatingSearch">Search by rating:</div>
            <div id="choiceRating" class="toggleOffList" onclick="toggleRatingList()">
                <?php
                    include 'park_select_list.inc';
                    echo isset($_GET['rating']) && $_GET['rating'] != "" && intval($_GET['rating']) <=5 && intval($_GET['rating']) >=1 ? $_GET['rating'] . " star" : "Select rating";
                ?>
            </div>
            <label for="ratingList"></label>
            <select id="ratingList" size="5" onchange="setSelectedRating(this)">
                <option value="No rating">No rating</option>
                <option value="1">1 star</option>
                <option value="2">2 star</option>
                <option value="3">3 star</option>
                <option value="4">4 star</option>
                <option value="5">5 star</option>
            </select>
        </div>

        <div id="suburbSearch">
            <div id="titleSuburbSearch">Suburb:</div>
            <div id="choiceSuburb" class="toggleOffList" onclick="toggleSuburbList()">
                <?php echo $selected_suburb != "" ? $selected_suburb : "Select suburb"; ?>
            </div>
            <label for="suburbList"></label>
            <select id="suburbList" size="5" onchange="setSelectedSuburb(this)">
                <?php
                    echo $suburb_option_list;
                ?>
            </select>
        </div>

        <div id="currentLocationSearch">
            <div id="titleCurrentLocation">Location</div>
            <div id="readCurrentLocation_search" onclick="geolocation(this)">
                <img id="location-marker_search" src="img/location-marker.png" alt="Location-Marker" width="20" height="20">
                <span id="location_status_search" style="padding-left: 2px">Use Current Location</span>
            </div>
        </div>
    </div>

    <div class="modal-map-box" id="modal-map">
        <div id="map-wrapper">
            <div id="map-wrapper-close" onclick="closeModalMap()">&#10006;</div>
            <div id="map-canvas"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYeoI9jOacSlRpLXaOrKmaBlayhSKISOk&callback=initMap"></script>
        </div>
    </div>

    <div><button id="view-map" onclick="openModalMap()">View map</button></div>
    <div id="search-result-wrapper">
        <?php
            include 'fetch_result.inc';
        ?>
        <script>
            document.getElementById('loader').style.display = "none";
            document.getElementById('result-title-count').innerText
                = "Show <?php echo intval($first_item+1). " - " . intval(($first_item+1)+($num_item_count-1));?> of " + <?php echo $page_count; ?>;
        </script>
    </div>
    <?php
        include 'pagination.inc';
     ?>
    <!-- Footer -->
    <?php
        include 'footer.inc';
    ?>

</body>
</html>