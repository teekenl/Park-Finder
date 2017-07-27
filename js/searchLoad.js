/**
 * Created by Ken on 7/05/2017.
 */

// Open modal map for location view
function openModalMap(){
    document.getElementById('modal-map').style.marginTop = "0px";
}

// Close modal map
function closeModalMap(){
    document.getElementById('modal-map').style.marginTop = "-1000px";
}

/* Toggle off and close the surburb list*/
function setSelectedSuburb(e){
    var choice = document.getElementById('choiceSuburb');
    choice.innerHTML = e.value;
    document.getElementById('suburb').value = e.value;
    e.style.display= "none";
}

/* Toggle and expand the surburb list*/
function toggleSuburbList(){
    var list = document.getElementById('suburbList');
    if (list.style.display === 'block') {
        list.style.display = 'none';
    } else{
        list.style.display= "block";
    }
}

/* Toggle off and close the rating*/
function setSelectedRating(e){
    var choice = document.getElementById('choiceRating');
    choice.innerHTML = e.value;
    document.getElementById('rating').value = e.value;
    e.style.display= "none";
}

/* Toggle and expand the ratinglist*/
function toggleRatingList(){
    var list = document.getElementById('ratingList');
    if (list.style.display === 'block') {
        list.style.display = 'none';
    } else{
        list.style.display= "block";
    }
}


