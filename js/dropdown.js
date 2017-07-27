/**
 * Created by dknig on 19/05/2017.
 */

function drop_down() {
    document.getElementById('main-dropdown').classList.toggle("show");
    document.getElementById('account-status').classList.toggle("show_arrow");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.nav-log-in-wrapper') && document.getElementsByClassName('nav-log-in-wrapper')!==null) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
        document.getElementById('account-status').classList.remove('show_arrow');
    }

    if(!event.target.matches('.toggleOffList') && document.getElementsByClassName('toggleOffList')!==null) {
        var list = document.getElementById('suburbList');
        var list2 = document.getElementById('ratingList');
        if(list.style.display==='block') {
            list.style.display= "none";
        }
        if (list2.style.display==='block'){
            list2.style.display="none";
        }
    }
};