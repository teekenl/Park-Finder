/**
 * Created by Ken on 6/05/2017.
 */

// Validation checking when users enter their email for password reset.
function password_validation(){

    if(!checkResetPasswordEmail()) {
        return false;
    } else {
        document.getElementById('get_password').value = "Sending...";
        return true;
    }
}

// Helper function to check whether the email is empty or not
function checkResetPasswordEmail(){
    var reset_email = document.getElementById('recovery_email');
    var error_message = document.getElementById('error-recovery-message');

    if(reset_email.value.length <= 0) {
        error_message.style.visibility = "visible";
        error_message.innerText = "The reset email is required";
        reset_email.style.borderColor = "red";
        return false;
    } else {
        error_message.style.visibility = "hidden";
        error_message.innerText = "";
        reset_email.style.borderColor = "red";
    }
    return true;
}

//  Close the modal box when user click close button
function user_modal_close(event){
    if (event.id==="invalid-user-modal-close") {
        document.getElementById('invalid-user-Modal').style.display="none";
    } else{
        document.getElementById('valid-user-Modal').style.display="none";
    }

}
