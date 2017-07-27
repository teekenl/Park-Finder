<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/loading.css" />
</head>
<body>
<div class="loader"></div>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 6/05/2017
 * Time: 6:27 PM
 */
include 'db_connect.inc';
if ( isset($_POST['firstname']) && isset($_POST['lastname']) &&
    isset($_POST['sign-up-password']) && isset($_POST['sign-up-email']) &&
    isset($_POST['sign-up-birth-date']) && isset($_POST['sign-up-contactNumber'])){

    // initialize the input value from requested form into variable
    $account_adding_status = "Please wait...";
    $username = htmlspecialchars($_POST['firstname'] . $_POST['lastname']);
    $username = trim($username);
    $first_name = htmlspecialchars(trim($_POST['firstname']));
    $last_name = htmlspecialchars(trim($_POST['lastname']));
    $password = md5($_POST['sign-up-password']);
    $birth_date = date('Y-m-d',strtotime($_POST['sign-up-birth-date']));
    $phoneNumber = trim($_POST['sign-up-contactNumber']);
    $email = htmlspecialchars(trim($_POST['sign-up-email']));
    echo $account_adding_status;

    if (isset($username) && isset($password) && isset($email) && isset($birth_date)&& isset($phoneNumber)
        && isset($first_name) && isset($last_name)) {
        $sql = $db->prepare("INSERT INTO user_details (user_id,user_name,user_fname,user_lname,user_email,user_birthdate,user_contactNumber,user_password) VALUES (NULL,:user_name,:user_fname,:user_lname,:user_email,:user_birthdate,:user_contactNumber,:user_password)");
        $sql->bindParam(':user_name',$username);
        $sql->bindParam(':user_birthdate',$birth_date);
        $sql->bindParam(':user_fname',$first_name);
        $sql->bindParam(':user_lname',$last_name);
        $sql->bindParam('user_contactNumber',$phoneNumber);
        $sql->bindParam(':user_password',$password);
        $sql->bindParam(':user_email',$email);

        if($sql->execute()){
            // Prompty successful message if it is correct
            $account_adding_status = "Added Successfully";
            echo $account_adding_status;
            echo "<script>window.location.href='signin.php';</script>";
        } else{
            // Prompt database connection issues if the network connectivity is weak
            echo "<br/>Network error. Please try refresh it again";
            echo "<script>window.location.href='signup.php';</script>";
        }

    } else{
        echo "Data input is empty or incorrect";
    }
} else {
    // Prompt the message if user didnt entered any detail
    $account_adding_status = "The data input is empty";
    echo $account_adding_status;
    echo "<script>window.location.href='signup.php'</script>";
}
?>