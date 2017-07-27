/**
 * Created by Ken on 17/04/2017.
 */

// The user login-status and their corresponding username
var user_status = {
    user_exist : 0,
    user_name : null
};

// Open modal box for user to write their review
function closeModalBox() {
    var modalBox = document.getElementById('modal-box');
    modalBox.style.display = "none";
    review_comment_form_reset();
}

// Close the modal after user has entered their review
function openModalBox() {
    var modalBox = document.getElementById('modal-box');
    if(user_status.user_exist) {
        modalBox.style.display = "block";
    } else{
        alert('Please login to make review');
        window.location.href='signin.php';
    }
}

// Open modal map for location view
function closeReviewModalMap(){
    document.getElementById('review-modal-map').style.marginTop = "-1000px";
}

// Close modal map
function openReviewModalMap(){
    document.getElementById('review-modal-map').style.marginTop = "0px";
}

// Validation checking for user input for review
function validateReviewForm() {
    if(!checkHeadline()) {
        if (!checkReviewComment()) {
            return false;
        }
        return false;
    } else if(!checkReviewComment()) {
        return false;
    }
    return true;
}

// Helper function to check the headline of review is empty or not
function checkHeadline() {
    var headline = document.getElementById('review-write-headline');
    var errorHeadline = document.getElementById('error-headline');
    if(headline.value.length === 0) {
        errorHeadline.style.visibility = "visible";
        errorHeadline.innerText = "Headline is a required field";
        headline.style.borderColor = "red";
        return false;
    } else {
        errorHeadline.style.visibility = "hidden";
        headline.style.borderColor = "black";
        errorHeadline.innerText = "";
        return true;
    }
}

// Helper function to check the comment of review is empty or not
function checkReviewComment () {
    var comment = document.getElementById('review-write-comment');
    var errorCommentMessage = document.getElementById('error-comment');
    if(comment.value.length === 0) {
        errorCommentMessage.style.visibility = "visible";
        errorCommentMessage.innerText = "Comment is a required field";
        comment.style.borderColor = "red";
        return false;
    } else {
        comment.style.borderColor = "black";
        errorCommentMessage.style.visibility = "hidden";
        errorCommentMessage.innerText = "";
        return true;
    }
}


// Helper function to reset the review feedback form
function review_comment_form_reset(){
    var headline = document.getElementById('review-write-headline');
    var comment = document.getElementById('review-write-comment');
    var errorHeadline = document.getElementById('error-headline');
    var errorComment = document.getElementById('error-comment');
    headline.style.borderColor = "black";
    headline.value = "";
    comment.style.borderColor = "black";
    comment.value = "";
    errorHeadline.style.visibility = "hidden";
    errorHeadline.innerText = "";
    errorComment.style.visibility = "hidden";
    errorComment.style.innerText="";

}