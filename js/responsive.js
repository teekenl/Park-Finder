/**
 * Created by dknig on 24/05/2017.
 */

/* To change the navigation menu when it reached within width limit */
function navigationFunction(){
    console.log("sad");
    var x = document.getElementById("menu");
    if (x.className === "menuWrapper") {
        document.getElementById('menu-content-close').innerHTML = "&#10006;";
        x.className += " responsive";
    } else {
        document.getElementById('menu-content-close').innerHTML = "&#9776;";
        x.className = "menuWrapper";
    }
}

window.onclick = function(event){
    if(!event.target.matches('.menuWrapper') && !event.target.matches('.icon')) {
        document.getElementById('menu-content-close').innerHTML = "&#9776;";
        document.getElementById("menu").className = "menuWrapper";
    }
};