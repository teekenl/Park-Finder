/**
 * Created by Ken on 18/05/2017.
 */

// Function to use geolocation
function geolocation(e){
    if (e.id.toString() === "readCurrentLocation") {
        document.getElementById('location-marker').src= "img/ajax-loader-small-circle.gif";
        document.getElementById('location_status').innerText = "Searching";
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition,showError);
        } else {
            console.log("Geolocation is not supported in this browser");
        }
    } else {
        document.getElementById('location-marker_search').src= "img/ajax-loader-small-circle.gif";
        document.getElementById('location_status_search').innerText = "Searching";
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition2,showError2);
        } else {
            console.log("Geolocation is not supported in this browser");
        }
    }

}

// To show coordinates of current location (longitude, latitude)
function showPosition(position){
    document.getElementById('currentLat').value = position.coords.latitude;
    document.getElementById('currentLng').value = position.coords.longitude;
    document.getElementById('search-place').value = "Current Location";
    document.getElementById('search-place').style.color = "dodgerblue";
    document.getElementById('location_status').innerText = "Successful";
    document.getElementById('location-marker').src= "img/Checkmark_Filled-50.png";
}

// To show coordinates of current location (longitude, latitude)
function showPosition2(position) {
    document.getElementById('currentLat_search').value = position.coords.latitude;
    document.getElementById('currentLng_search').value = position.coords.longitude;
    document.getElementById('location_status_search').innerText = "Successful";
    document.getElementById('search-text').value = "Current Location";
    document.getElementById('search-text').style.color = "dodgerblue";
    document.getElementById('location-marker_search').src= "img/Checkmark_Filled-50.png";
}

// Error function handling when the HTML geolocation API is not working
function showError(error) {
    alert(error);
}

// Error function handling hwne the HTML geolocation API is not working
function showError2(error) {
    alert(error);
}


// Function to reset and cancel the current location searching
function change_location_search(e){
    var subString = "Current Location";
    if(e.value.indexOf(subString)!==-1) {
        if(e.id.toString() === "search-place") {
            e.value = "";
            console.log('sad');
            document.getElementById('currentLng').value = "";
            document.getElementById('currentLat').value = "";
            document.getElementById('search-place').style.color = "black";
        } else {
            e.value = "";
            document.getElementById('currentLat_search').value = "";
            document.getElementById('currentLng_search').value = "";
            document.getElementById('search-text').style.color = "black";
        }
    }

}