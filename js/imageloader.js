/**
 * Created by Ken on 18/04/2017.
 */

var images = [], x = -1;
images[0] = "img/home_image1.jpg";
images[1] = "img/home_image2.jpg";
images[2] = "img/home_image3.jpg";
images[3] = "img/home_image4.jpg";
images[4] = "img/query_search_wallpaper.jpg";
images[5] = "img/home_image5.jpg";


imagediv = document.getElementById('image-elem');

// Function to load image with specified time interval
function displayNextImage() {

    x = (x === images.length - 1) ? 0 : x + 1;
    document.getElementById("image-elem").src = images[x];
}

// Load Image Timer Function
function startImageTimer() {
    setInterval(displayNextImage, 2000);
}
