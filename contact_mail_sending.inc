<?php
include("mail/phpmailer/class.smtp.php");
include("mail/phpmailer/class.phpmailer.php");

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
    //$mail->AddReplyTo($_POST['contact_email'],$_POST['contact_fname'] . " " .$_POST['contact_lname']);
    $mail->SetFrom($_POST['contact_email'],$_POST['contact_fname'] . " " .$_POST['contact_lname']);
    $mail->Subject = "Feedback / Contact Us";
    $mail->Body = "Feedback from: ".$_POST['contact_fname']." ".$_POST['contact_lname']."   (".$_POST['contact_email'].")<br/>".$_POST['contact_comment'];
    $mail->AddAddress("dknight1938@hotmail.com");
    if(!$mail->Send()){
        echo "Network error";
        false;
    }
    else {
        echo "<script>alert('Your feedback form has been sent')</script>";
        true;
    }

?>
