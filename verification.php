<html>
<body>
    <div>Please wait...</div>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 7/05/2017
 * Time: 4:24 PM
 */
    include ("db_connect.inc");

    $username = isset($_POST['username']) ?  htmlspecialchars($_POST['username']) : "";
    $password = isset($_POST['password']) ? md5($_POST['password']) : "";

    session_start();

    if ($username!="" && $password!="") {
        $username = trim($username);
        $password = trim($password);
        $sql = "SELECT * FROM user_details WHERE user_email='$username' AND user_password='$password'";
        $result = $db->query($sql);
        $rows = $result->rowCount();
        if ($rows>0) {
            foreach ($result as $row) {
                if (isset($_SESSION['review_url'])) {
                    // Redirect the user to review or individual item page if the user
                    // has recently viewed the item page before signing in.
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['user_name'];
                    $_SESSION['lname'] = $row['user_lname'];
                    echo "<script>alert('Successful!');window.location.href='".$_SESSION['review_url']."';</script>";
                    unset($_SESSION['review_url']);
                } else {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['user_name'];
                    $_SESSION['lname'] = $row['user_lname'];
                    echo "<script>alert('Successful!');window.location.href='search_query.php';</script>";
                }
                unset($_SESSION['error-login']);
                exit;
            }
        } else {
            // Set login error and prompt the error message if the login details is incorrect
            $_SESSION['error-login'] = 1;
            echo "<script>window.location.href='signin.php?error-login=1'</script>";
        }
    } else {
        echo "<script>window.location.href='signin.php';</script>";
    }

?>