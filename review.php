<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Park <?php echo isset($_GET['park_code']) ? $_GET['park_code']:"Review"; ?></title>
    <link rel="stylesheet" href="css/dropdown.css" type="text/css" />
    <link rel="stylesheet" href="css/review.css" type="text/css"/>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <script src="js/dropdown.js" type="text/javascript"></script>
    <script src="js/performreview.js" type="text/javascript"></script>
    <script src="js/map.js" type="text/javascript"></script>
</head>
<body>
    <!-- header -->
    <header>
        <div id="menu">
            <a href="index.php"><img id="main-picture" src="img/main_logo.png" alt="Park Photo" title="Park Photo" width="60" height="40"/></a>
            <?php
            include 'session_status.inc';

            if(!isset($_SESSION['username']) or !isset($_SESSION['user_id'])) {
                $_SESSION['review_url'] = "$_SERVER[REQUEST_URI]";
             } else{
                echo "<script>user_status.user_exist = 1; user_status.user_name=".$_SESSION['username']."</script>";
            }
            ?>
        </div>
    </header>

    <!-- Modal Box for google map view-->
    <div class="review-modal-map-box" id="review-modal-map">
        <div id="review-map-wrapper">
            <div id="review-map-wrapper-close" onclick="closeReviewModalMap()">&#10006;</div>
            <div id="review-map-canvas"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYeoI9jOacSlRpLXaOrKmaBlayhSKISOk&callback=initMap2"></script>
        </div>
    </div>

    <?php
        if(!isset($_GET['park_code']) or  !isset($_GET['park_id'])) {
            echo "<div style='font-size:1.2em;position:absolute;top:40%;left:45%;'>The URL entered is not found</div>";
            exit;
        } else {
            $park_code = isset($_GET['park_code']) ? $_GET['park_code'] : "";
            $park_id = isset($_GET['park_id']) ? $_GET['park_id'] : "";
            include 'get_park_detail.inc';
        }
    ?><br/><br/><br/><br/>

    <div id="nav-review-background-overlay"></div>

    <!-- Park details -->
    <div id="nav-review-wrapper" itemscope itemtype="http://schema.org/Place">
        <div id="review-place-name" itemprop="name">
            <?php include 'get_review_detail.inc';
                    echo $park_name;
                    for($i=1;$i<=intval($review_user_rating);$i++) {
                       echo "<span class='review-place-rating-main'>%%</span>";
                    }
            ?>
        </div>
        <div id="review-place-address" itemprop="address"><?php echo $park_street . ", " . $park_suburb; ?> </div>
        <button id="button-write-review" onclick="openModalBox()"> Write Review</button>
        <div id="review-place-image"><img itemprop="photo" src="img/park.jpg" alt="Park_" width="800" height="480">
            <div id="review-rating-wrapper">
                <div id="review-rating-level">
                    <?php
                        echo $review_level;
                     ?><br/><?php echo $review_percentage_rate;?>
                </div>
                <div id="review-rating-customer">of guest recommended</div>
                <?php
                    if($review_user_rating >= 1) {
                ?>
                    <div id="review-rating-count" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        <span style="font-weight: bold" itemprop="ratingValue">
                            <?php
                            echo $review_user_rating;
                            ?>
                        </span> out of <span itemprop="bestRating">5</span>
                        <span itemprop="reviewCount" style="visibility: hidden;"><?php echo $review_row_count; ?></span>
                    </div>
                    <div id="review-view-content"><a href="#review-content-wrapper">
                            <?php
                            echo $review_row_count > 0 ? "View all " . $review_row_count ." verified review ": " No review found ";
                            ?></a>
                    </div>

                <?php
                    } else {
                ?>
                    <div id="review-rating-count">
                    <span style="font-weight: bold">
                        <?php
                        echo $review_user_rating;
                        ?>
                    </span> out of <span>5</span>
                        <span style="visibility: hidden;"><?php echo $review_row_count; ?></span>
                    </div>
                    <div id="review-view-content"><a href="#review-content-wrapper">
                            <?php
                            echo $review_row_count > 0 ? "View all " . $review_row_count ." verified review ": " No review found ";
                            ?></a>
                    </div>
                <?php } ?>

                <div id="review-view-further-detail">
                    <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                        <span itemprop="latitude" content="<?php echo $lat;?>" ></span>
                        <span itemprop="longitude" content="<?php echo $lng; ?>" ></span>
                    </div>
                    <div id="review-distance-travel"><?php echo $distance;?> km away</div>
                    <div id="review-distance-get-direction"><a itemprop="hasMap" href="<?php echo rawurlencode("https://www.google.com.au/maps/search/$park_name");?>" target="_blank" style="text-decoration: none">Get direction</a></div>
                </div>
                <div id="review-place-map" onclick="openReviewModalMap();">
                    <div id="review-map-overlay"></div>
                    <img id="review-map-image" src="img/roadmap_icon.jpg" alt="road_map icon">
                    <button id="review-map-button" onclick="openReviewModalMap();">Go to Map</button>
                </div>
            </div>
        </div><br/><br/>

        <div id="review-content-wrapper">
            <?php
                include 'db_connect.inc';

                $sql = "SELECT * FROM user_review WHERE review_parkCode ='$park_code' AND review_park='$park_name' ORDER BY user_commentDate DESC ";
                $result = $db->query($sql);
                $row_count = $result->rowCount();

                if($row_count>0) {
                    foreach ($result as $row) {
                        $timestamp = strtotime($row['user_commentDate']);
                        $new_date_format = date('d F Y', $timestamp);
            ?>
                <div class="review-content-container" itemprop="review" itemscope itemtype="http://schema.org/Review">
                    <div class="customer-profile-details">
                        <div class="customer-rating-level" itemprop="contentRating"><?php echo$row['user_rating']?><span style="font-weight: 300;"> out of 5</span></div>
                        <div class="customer-profile-name" itemprop="author">by <?php echo$row['user_name']?></div>
                    </div>
                    <div class="customer-profile-comment-headline" itemprop="comment"><?php echo$row['user_headline']?></div>
                    <div class="customer-profile-posting-date" itemprop="datePublished">Posted <?php echo$new_date_format?></div>
                    <div class="customer-profile-comment-content" itemprop="description"><?php echo $row['user_comment']?></div>
                </div>
            <?php
                    }
                } else{
                    echo "<div id='no-review-result'>No review</div>";
                }
            ?>
        </div>
    </div>

    <div class="modal-box-class" id="modal-box">
        <div id="review-modal-box">
            <div id="review-write-title">Write Review</div>
            <div id="review-write-close" onclick="closeModalBox()">&#10006;</div>
            <form id="review-write-form" action="add_Review.php" onsubmit="return validateReviewForm(); " method="post">
                <label for="review-write-headline" id="label-headline">Headline *</label><br/>
                <span class="error-Message" id="error-headline"></span><br/>
                <input type="text" id="review-write-headline" name="user-headline" maxlength="100" placeholder="Title of Subject" autocomplete="off" oninput="checkHeadline()">
                <label for="review-write-comment" id="label-comment">Comment *</label><br/><br/>
                <span class="error-Message" id="error-comment"></span><br/>
                <textarea id="review-write-comment" name="user-comment" cols="30" rows="4" maxlength="250" placeholder="Write Comment Here." autocomplete="off" oninput="checkReviewComment()"></textarea>
                <input type="hidden" name="parkcode" value="<?php echo $park_code; ?>"/>
                <input type="hidden" name="parkname" value="<?php echo $park_name; ?>"/>
                <input type="hidden" name="parkid" value="<?php echo $park_id; ?>"/>
                <div id="ratingStar">
                    <label style="position: absolute; left: 1%;">Rating</label><br/>

                    <span class="circle-rating-choose">
                            <input id="str5" name="user-rating" type="radio" value="5"><label for="str5"></label>
                            <input id="str4" name="user-rating" type="radio" value="4"><label for="str4"></label>
                            <input id="str3" name="user-rating" type="radio" value="3"><label for="str3"></label>
                            <input id="str2" name="user-rating" type="radio" value="2"><label for="str2"></label>
                            <input id="str1" name="user-rating" type="radio" value="1"><label for="str1"></label>
                    </span>
                </div>
                <input type="submit" value="Submit"><br/>
            </form>
        </div>
    </div>

    <?php
        include 'footer.inc';
    ?>

</body>
</html>
