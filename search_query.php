<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Query Search</title>
    <script src="js/geolocation.js" type="text/javascript"></script>
    <script src="js/dropdown.js" type="text/javascript"></script>
    <script src="js/validation.js" type="text/javascript"></script>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <link rel="stylesheet" href="css/dropdown.css" type="text/css" />
    <link rel="stylesheet" href="css/query.css"/>

</head>
<body>
    <!-- Header -->
    <header>
        <div id="menu">
            <a href="index.php"><img id="main-picture" src="img/main_logo.png" alt="Park Photo" title="Park Photo" width="60" height="40"/></a>
            <?php
            include 'session_status.inc';
            ?>
        </div>
    </header>

    <div id="nav-query-search-wrapper">
        <div id="nav-overlay"></div>
        <div id="sub-query-wrapper">
            <form action="loading.php" id="querySearch" method="get" onsubmit="return query_validation();" >
                <div id="sub-query-wrapper-title">Search Filter</div><br/><br/>
                <?php include 'park_datalist.inc' ?>
                <span id="errorQueryMessage"></span>
                <label for="search-place">Place</label><br/>
                <input list="park_place" type="text" placeholder="eg: Brisbane City" name="place" id="search-place" onfocus="change_location_search(this)"/><br/>
                <datalist id="park_place">
                    <?php
                        echo $park_place_list;
                    ?>
                </datalist>
                <label for="search-suburb">Suburb</label><br/>
                <input list="park_suburb" type="text" placeholder="eg: King George" name="suburb" id="search-suburb" /><br/>
                 <datalist id="park_suburb" >
                     <?php
                        echo $park_suburb_list;
                     ?>
                 </datalist>
                <label >Rating</label><br/>
                <span class="circle-rating-choose">
                    <input id="str5" type="radio" name="rating" value="5"><label for="str5"></label>
                    <input id="str4" type="radio" name="rating" value="4"><label for="str4"></label>
                    <input id="str3" type="radio" name="rating" value="3"><label for="str3"></label>
                    <input id="str2" type="radio" name="rating" value="2"><label for="str2"></label>
                    <input id="str1" type="radio" name="rating" value="1"><label for="str1"></label>
                </span><br/><br/>

                <label>Current Location</label>
                <input type="hidden" name="currentLat" id="currentLat" />
                <input type="hidden" name="currentLng" id="currentLng"/>
                <div id="currentLocationSearch">
                    <div id="readCurrentLocation" onclick="geolocation(this)">
                        <img id="location-marker" src="img/location-marker.png" alt="Location-Marker" width="20" height="20">
                        <span id="location_status">Use Current Location</span>
                    </div>
                </div>

                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php
        include 'footer.inc';
    ?>

</body>
</html>