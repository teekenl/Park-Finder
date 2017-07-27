/**
 * Created by dknig on 20/05/2017.
 */

/* To validate the form validation for password reset */
function reset_password_validation(){
    if(!check_reset_password()) {
        if (!check_confirm_reset_password()) {
            return false;
        }
        return false;
    } else if (!check_confirm_reset_password()) {
        return false;
    }
    document.getElementById('update_reset_password').value = "Updating...";
    return true;
}

/* To valid the reset password */
function check_reset_password(){
    var reset_password = document.getElementById('reset_password');
    var errorMessage = document.getElementById('error-reset-message');
    if(reset_password.value.length === 0) {
        reset_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The new password is required field";
        return false;
    } else if(!checkResetPasswordContainsDigit(reset_password)) {
        reset_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The new password must contains a number digit";
        return false;
    } else if (!checkResetPasswordContainsUpperCase(reset_password)) {
        reset_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The new password must contains one upper case letter";
        return false;
    } else if(reset_password.value.length < 8) {
        reset_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The new password must contains at least 8 characters";
        return false;
    } else {
        reset_password.style.borderColor = "black";
        errorMessage.style.visibility = "hidden";
        errorMessage.innerText = "";
    }
    return true;
}

/* To valid the reset confirm password */
function check_confirm_reset_password(){
    var reset_password = document.getElementById('reset_password');
    var reset_confirm_password = document.getElementById('reset_confirm_password');
    var errorMessage = document.getElementById('error-reset-confirm-message');

    if(reset_confirm_password.value.length===0) {
        reset_confirm_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The confirm password is required field";
        return false;
    } else if(reset_password.value.toLowerCase() !== reset_confirm_password.value.toLowerCase()) {
        reset_confirm_password.style.borderColor = "red";
        errorMessage.style.visibility = "visible";
        errorMessage.innerText = "The new and confirm password is not match";
        return false;
    } else{
        reset_confirm_password.style.borderColor = "black";
        errorMessage.style.visibility = "hidden";
        errorMessage.innerText = "";
    }
    return true;
}

/* To validate the password must contains a digit*/
function checkResetPasswordContainsDigit(newPassword){

    for (var i = 0; i < newPassword.value.length; i++) {
        if(parseInt(newPassword.value[i])) {
            return true;
        }
    }
    return false;
}

/* To validate the password must contains a single upper case letter*/
function checkResetPasswordContainsUpperCase(newPassword) {

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
