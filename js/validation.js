/**
 * Created by Ken on 12/04/2017.
 */

/* Email object used to validate the unique email */
var emailValidation = {
    unique: false,
    list_email: null,
    emailLoad: function (list_email) {
        this.list_email = list_email;
    },
    checkExist: function (target) {
        if (this.list_email.length>0) {
            this.unique = true;
            for (var i= 0; i < this.list_email.length; i++) {
                if(target.value === this.list_email[i] ){
                    this.unique = false;
                    break;
                }
            }
        }
    },
    isunique: function () {
        return this.unique;
    },
    test: function(){
       console.log("asd");
    }
};

// The step used to solve the weak warnings, It has nothing to do with website
emailValidation.emailLoad(null);

/* Validate the username and password input, prompts out error Message if they are*/
function loginValidation(){

    if(!checkUsername()) {
        if(!checkPassword()) {
            return false;
        }
        return false;
    } else if(!checkPassword()){
        return false;
    }
    document.getElementById('log-in-button').value = "Signing in...";
    return true;
}

/* Validate the Firstname*/
function signupValidation(){
    var validationArrayFunction = {
        '1': checkFirstName(),
        '2': checkLastName(),
        '3': checkBirthDate(),
        '4': checkPhoneNumber(),
        '5': checkHotmail(),
        '6': checkNewPassword(),
        '7': checkMatchPassword()
    };
    var allValidate = false;
    for (var i=1;i<=7;i++) {
        if (validationArrayFunction[i.toString()]){
            allValidate = true;
        }else{
            allValidate = false;
            break;
        }
    }

    if(!allValidate) {
        return false;
    } else{
        document.getElementById('sign-up-button').value = "Registering...";
        return true;
    }
}

/* Validation used for query checking */
function query_validation(){
    var error = document.getElementById('errorQueryMessage');
    if(!checkPlaceSearch() && !checkSuburbSearch() && !checkRatingSearch() && !checkNearbySearch()) {
        error.innerText = "Please choose at least one option";
        error.style.visibility= "visible";
        return false;
    } else{
        error.innerText = "";
        error.style.visibility= "hidden";
        return true;
    }
}

/* Validation for feedback form */
function contact_us_validation(){
    var contact_us = {
        '1': checkCommentFirstName(),
        '2': checkCommentLastName(),
        '3': checkCommentEmail(),
        '4': checkCommentInput()
    };
    var all_validate = false;
    for(var i=1;i<=4;i++){
        if (contact_us[i.toString()]) {
            all_validate = true;
        } else{
            all_validate = false;
            break;
        }
    }

    return all_validate;
}

/* To check the username input whether it is empty*/
function checkUsername() {
    var username = document.getElementById('username');
    var errorMessage = document.getElementById('username-error');

    if(username.value.length <= 0) {
        username.style.borderColor = "red";
        errorMessage.innerText = "Email is required field";
        errorMessage.style.display = "block";
        return false;
    } else if(!checkHTMLSpecialChar(username)){
        username.style.borderColor = "red";
        errorMessage.innerText = "Email should contains only @ or . or _";
        errorMessage.style.display = "block";
        return false;
    } else {
        errorMessage.innerText = "";
        errorMessage.style.display = "none";
        username.style.borderColor = "white";
    }
    return true;
}

/* To check the password input whether it is empty*/
function checkPassword() {
    var password = document.getElementById('password');
    var errorMessage = document.getElementById('password-error');

    if(password.value.length <= 0) {
        errorMessage.innerText = "Password is required field";
        password.style.borderColor = "red";
        errorMessage.style.display = "block";
        return false;
    } else {
        errorMessage.innerText = "";
        password.style.borderColor = "white";
        errorMessage.style.display= "none";
    }

    return true;
}

/* To check first name input whether it is blank*/
function checkFirstName() {
    var firstName = document.getElementById('firstname');
    var errorMessage = document.getElementById('error-user-name-message');

    if(firstName.value.length <= 0 ) {
        errorMessage.innerText = "First or Last name is required field";
        firstName.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(!checkHTMLAllSpecialChar(firstName)){
        errorMessage.innerText = "First or Last name should not contains special characters";
        firstName.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else {
        errorMessage.innerText = "";
        firstName.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }

    return true;
}

function checkPhoneNumber(){
    var phone = document.getElementById('sign-up-number');
    var errorMessage = document.getElementById('error-phone-message');
    if (phone.value.length<=0) {
        errorMessage.innerText = "Phone Number is required field";
        phone.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(phone.value.length < 10 ) {
        errorMessage.innerText = "Phone number is invalid";
        phone.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else{
        errorMessage.innerText = "";
        phone.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }
    return true;
}

/* To check last name input whether it is blank */
function checkLastName() {
    var lastName = document.getElementById('lastname');
    var errorMessage = document.getElementById('error-user-name-message');

    if(lastName.value.length <= 0 ) {
        errorMessage.innerText = "First or Last Name is required field";
        lastName.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    }  else if(!checkHTMLAllSpecialChar(lastName)){
        errorMessage.innerText = "First or Last name should not contains special characters";
        lastName.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else {
        errorMessage.innerText = "";
        lastName.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }

    return true;
}

function checkBirthDate(){
    var today = new Date();
    var birth_date = document.getElementById('sign-up-birth-date');
    var errorMessage = document.getElementById('error-birth-date-message');
    var inputDate = new Date(document.getElementById('sign-up-birth-date').value);
    if (birth_date.value.trim() === ""){
        errorMessage.innerText = "Birth Date is required field";
        birth_date.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if (inputDate > today) {
        errorMessage.innerText = "Birth Date is invalid";
        birth_date.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else {
        errorMessage.innerText = "";
        birth_date.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }
    return true;
}

/* To validate hotmail input, it is blank */
function checkHotmail() {
    var hotmail = document.getElementById('sign-up-email');
    var errorMessage = document.getElementById('error-sign-up-email-message');
    emailValidation.checkExist(hotmail);
    if(hotmail.value.length <= 0 ) {
        errorMessage.innerText = "Hotmail is required field";
        hotmail.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(!checkHTMLSpecialChar(hotmail)){
        hotmail.style.borderColor = "red";
        errorMessage.innerText = "Email should contains only @ or . or _";
        errorMessage.style.visibility = "visible";
        return false;
    } else if (!emailValidation.isunique()){
        errorMessage.innerText = "Hotmail is already taken";
        hotmail.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else {
        errorMessage.innerText = "";
        hotmail.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }
    return true;
}

/* To validate the password input, whether it is blank */
function checkNewPassword() {
    var newPassword = document.getElementById('sign-up-password');
    var errorMessage = document.getElementById('error-sign-up-password-message');
    if(newPassword.value.length <= 0 ) {
        errorMessage.innerText = "Password is required field";
        newPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(newPassword.value.length <8) {
        errorMessage.innerText = "Password should be at least 8 character in length";
        newPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(!checkPasswordContainsDigit()) {
        errorMessage.innerText = "Password should contains at least a digit";
        newPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(!checkPasswordContainsUpperCase()) {
        errorMessage.innerText = "Password should be at least a upper case letter";
        newPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else {
        errorMessage.innerText = "";
        newPassword.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }

    return true;
}

/* To validate the similarity between password and confirm password, return error message they are both not matching*/
function checkMatchPassword() {
    var newPassword = document.getElementById('sign-up-password');
    var confirmPassword = document.getElementById('sign-up-confirmPassword');
    var errorMessage = document.getElementById('error-sign-up-confirm-password-message');
    if(newPassword.value.toLowerCase() !== confirmPassword.value.toLowerCase()) {
        errorMessage.innerText = "Confirm Password is non-matched";
        confirmPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else if(confirmPassword.value.length<=0) {
        errorMessage.innerText = "Confirm Password is required field";
        confirmPassword.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        return false;
    } else{
        errorMessage.innerText = "";
        confirmPassword.style.borderColor = "white";
        errorMessage.style.visibility = "hidden";
    }
    return true;
}

/* To validate the special characters of html for text input */
function checkHTMLSpecialChar(target){
    return !(/[-!$%^&*()+|~=`{}\[\]:";'<>?,\/]/.test(target.value));
}

function checkHTMLAllSpecialChar(target){
    return !(/[-!$_@.%^&*()+|~=`{}\[\]:";'<>?,\/]/.test(target.value));
}

/* To validate the password must contains a digit*/
function checkPasswordContainsDigit(){
    var newPassword = document.getElementById('sign-up-password');

    for (var i = 0; i < newPassword.value.length; i++) {
        if(parseInt(newPassword.value[i])) {
            return true;
        }
    }
    return false;
}

/* To validate the password must contains a single upper case letter*/
function checkPasswordContainsUpperCase() {
    var newPassword = document.getElementById('sign-up-password');

    for(var i = 0 ; i < newPassword.value.length; i++) {
        if(parseInt(newPassword.value[i])) {
            continue;
        }
        if(newPassword.value[i] === newPassword.value[i].toUpperCase()) {
            return true;
        }
    }
    return false;
}

/* To validate the query for place is empty or not */
function checkPlaceSearch(){
    var place = document.getElementById('search-place');
    return place.value!=="";
}

/* To validate the query for suburb is empty or not */
function checkSuburbSearch(){
    var suburb = document.getElementById('search-suburb');
    return suburb.value!=="";
}

/* To validate the query for rating is empty or not */
function checkRatingSearch(){
    var inputRating = false;
    var rating = document.getElementsByName('rating');
    for (var i = 0, length = rating.length; i < length; i++) {
        if (rating[i].checked) {
            inputRating = true;
            break;
        }
    }
    console.log(inputRating);
    return inputRating;
}

/* To validate the query for nearby is empty or not */
function checkNearbySearch(){
    var currentLat = document.getElementById('currentLat');
    var currentLng = document.getElementById('currentLng');

    if(currentLat.value==="") {
        return false;
    } else if(currentLng.value===""){
        return false;
    }
    return true;
}

/* To validate the first name input for feedback form is empty or not */
function checkCommentFirstName(){
    var firstName = document.getElementById('comment-firstname');
    firstName.style.borderColor =  firstName.value !=="" ? "":"red";
    console.log("asd");
    return firstName.value !== "";
}

/* To validate the first name input for feedback form is empty or not */
function checkCommentLastName(){
    var lastName = document.getElementById('comment-lastname');
    lastName.style.borderColor =  lastName.value !=="" ? "":"red";
    return lastName.value !== "";
}

/* To validate the email input for feedback form is empty or not */
function checkCommentEmail(){
    var email = document.getElementById('comment_email');
    email.style.borderColor =  email.value !=="" ? "":"red";
    return email.value !== "";
}

/* To validate the comment input for feedback form is empty or not */
function checkCommentInput(){
    var comment = document.getElementById('contact_comment');
    comment.style.borderColor =  comment.value !=="" ? "":"red";
    return comment.value !== "";
}