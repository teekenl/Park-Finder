/**
 * Created by Ken on 10/05/2017.
 */

/** The file used for map initialization along with their particular details
 *  Also the position of location marker in the map
 **/

// Map function for search php page
function initMap($park_details) {

    var mapProp;
    if ($park_details !== undefined) {
        var center_x = $park_details[0][5];
        var center_y = $park_details[0][6];

        mapProp= {
            center:new google.maps.LatLng(center_x,center_y),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var infowindow = new google.maps.InfoWindow();
        var marker, i,markers=[];
        var formatted_content = "";

        var map = new google.maps.Map(document.getElementById("map-canvas"),mapProp);

        var image = {
            url: "img/sign.png",
            scaledSize: new google.maps.Size(60, 60)
        };

        for(i =0;i<$park_details.length;i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng($park_details[i][5],$park_details[i][6]),
                icon: image,
                title: $park_details[0][1],
                animation: google.maps.Animation.DROP,
                map : map
            });
            markers[i] = marker;

            google.maps.event.addListener(marker,'click',(function(marker,i) {
                return function (){
                    toggleBounce(markers, marker);
                    formatted_content = "";
                    formatted_content += "<div style='font-weight:500;'>"+$park_details[i][2]+"</div>";
                    formatted_content += "<div style='font-size:0.9em;'>"+$park_details[i][4]+"</div>";
                    formatted_content += "<div style='font-size:0.9em;>"+$park_details[i][3] +" QLD</div>";
                    formatted_content += "<div style='font-size:0.9em;>Australia</div>";
                    formatted_content += "<div><a href='review.php?park_code="+$park_details[i][0]+"&park_id="+$park_details[i][1]+"'>View Park Details</a></div>";
                    infowindow.setContent(formatted_content);
                    infowindow.open(map,marker);
                }
            })(marker,i));
        }

    } else{
        mapProp= {
            center:new google.maps.LatLng(51.508742,-0.120850),
            zoom:5
        };

        var map2 = new google.maps.Map(document.getElementById("map-canvas"),mapProp);
    }

    function toggleBounce(markers,marker){
        for(var i =0; i<markers.length;i++) {
            if(markers[i].getAnimation()!==null) {
                markers[i].setAnimation(null);
            }
        }
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

// Map function for review php page
function initMap2($park_info){

    var mapProp;

    if($park_info !== undefined) {

        mapProp = {
            center: new google.maps.LatLng($park_info[4],$park_info[5]),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var infoWindow = new google.maps.InfoWindow();
        var marker;
        var formatted_content;

        var map = new google.maps.Map(document.getElementById("review-map-canvas"),mapProp);

        var image = {
            url: "img/sign.png",
            scaledSize: new google.maps.Size(60, 60)
        };

        marker = new google.maps.Marker({
            position:  new google.maps.LatLng($park_info[4],$park_info[5]),
            icon: image,
            title: $park_info[1],
            animation: google.maps.Animation.DROP,
            map: map
        });

        google.maps.event.addListener(marker,'click',(function(marker) {
            return function(){
                formatted_content = "";
                toggleBounce(marker);
                formatted_content += "<div style='font-weight:500;'>"+$park_info[1]+"</div>";
                formatted_content += "<div style='font-size:0.9em;'>"+$park_info[2]+"</div>";
                formatted_content += "<div style='font-size:0.9em;'>"+$park_info[3]+"QLD</div>";
                formatted_content += "<div style='font-size:0.9em;'>Australia</div>";
                formatted_content += "<div><a href='' onclick='closeReviewModalMap();'>Close map</div>";
                infoWindow.setContent(formatted_content);
                infoWindow.open(map,marker);
            }
        })(marker));

    } else {
        mapProp =  {
            center: new google.maps.LatLng(51,508742,-0.120850),
            zoom: 5
        };

        var map2 = new google.maps.Map(document.getElementById("review-map-canvas"),mapProp);
    }

    function toggleBounce(marker){
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

