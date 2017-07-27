<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading</title>
    <link rel="icon" type="image/gif" href="img/main_logo.png" />
    <link rel="stylesheet" href="css/loading.css"/>
</head>
<body>
    <div class="loader"></div>
    <?php
        $places = isset($_GET['place']) ? htmlspecialchars($_GET['place']):"";
        $suburb = isset($_GET['suburb'])? htmlspecialchars($_GET['suburb']):"";
        $rating = isset($_GET['rating']) ? htmlspecialchars($_GET['rating']) : "";
        if($places=="" && !isset($_GET['currentLat']) && !isset($_GET['currentLng'])) {
            echo "<script>window.location.href='search_query.php';</script>";
        }
        if (isset($_GET['currentLat']) and isset($_GET['currentLng']) && trim($_GET['currentLng'])!= "" and trim($_GET['currentLat'])!= "") {
            $coordinates = $_GET['currentLat'] . "," . $_GET['currentLng'];
            echo "<script>window.location.href='search.php?coords=$coordinates&suburb=$suburb&rating=$rating'</script>";
        } else{
            echo "<script> window.location.href='search.php?place=$places&suburb=$suburb&rating=$rating'</script>";
        }
    ?>
</body>

