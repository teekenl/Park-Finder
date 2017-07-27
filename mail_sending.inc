<?php
    include("mail/phpmailer/class.smtp.php");
    include("mail/phpmailer/class.phpmailer.php");
    include("db_connect.inc");

    $sql = "SELECT * FROM user_details WHERE user_email='$recovery_email'";
    $result = $db->query($sql);
    $user_details = array();
    if($result->rowCount() > 0 ) {
        echo "<script>document.getElementById('nav-pwd-recovery-wrapper').style.display = \"none\";</script>";
        echo "<script>document.getElementById('nav-pwd-recovery-wrapper2').style.display = \"block\";</script>";

        foreach ($result as $row) {
            $user_details[0] = $row['user_email'];
            $user_details[1] = $row['user_fname'];
            $user_details[2] = $row['user_lname'];
            $user_details[3] = $row['user_id'];
        }

        $mail = new PHPMailer(); // create a new object
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = mess
        $mail->IsSMTP(); // enable SMTPages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
        $mail->CharSet="utf-8";
        $mail->Encoding="base64";
        $mail->IsHTML(true);
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; // or 587
        $mail->Username = "brisbaneparks2@gmail.com";
        $mail->Password = "noob12345";
        $mail->SetFrom("brisbaneparks2@gmail.com","Brisbane Park Support");
        $mail->Subject = "Password Reset";
        $mail->Body = mail_format_html_content($user_details);
        $mail->AddAddress($user_details[0],$user_details[1]. $user_details[2]);
        if(!$mail->Send()){
            echo "Network error";
            false;
        }
        else
            echo "<script>document.getElementById('valid-user-Modal').style.display=\"block\";</script>";
        true;
    } else {
        echo "<script>document.getElementById('invalid-user-Modal').style.display=\"block\";</script>";
    }


    // Function to format html content to be displayed in mail
    function mail_format_html_content($user_details){
        $current_timestamp = time();
        $html_content = "";
        $html_content .= "<html><body>";
        $html_content .= "<h1>The Password Reset for ".$user_details[0]."</h1>";
        $html_content .= "<p>Hi ".$user_details[2].",</p>";
        $html_content .= "<p>Username:". $user_details[1]." ".$user_details[2]."</p>";
        $html_content .= "<a href='https://".$_SERVER['HTTP_HOST']."/n9532897/reset_password.php?recovery_email=".$user_details[0]."&recovery_user_id=".$user_details[3]."&timestamp=".$current_timestamp."'>Click here to reset the password</a>";
        $html_content .= "<br><br/><h4>Dont recognize this activity?</h4>";
        $html_content .= "<p>Click to report.</p>";
        $html_content .= "<br/><br><address>The Brisbane Park Support Team.</address>";
        $html_content .= "<br/><br><address>Please do not reply this email.</address>";
        $html_content .= "</body></html>";

        return $html_content;
    }

?>
