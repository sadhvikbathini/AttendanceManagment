<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

function sendPasswordResetLink($email, $token) {
		$mail = new PHPMailer;
	try {
		$mail->isSMTP(); 
		// $mail->SMTPDebug = 2; 
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = "587"; // typically 587 
		$mail->SMTPSecure = 'tls'; // ssl is depracated
		$mail->SMTPAuth = true;
		$mail->Username = "Your Email ID";
		$mail->Password = "Your Password";

		$mail->setFrom("amskucet@gmail.com", "AMS - KUCET");
		$mail->addAddress($email);

		$mail->isHTML(true);
		$mail->Subject = 'Reset your password';
		$url = "https://kucet.rf.gd/reset-password.php?token=$token";
		$mail->Body = "Hi,<br><br>Please click on the link below to reset your password:<br><br><a href='$url'>$url</a><br><br>If you did not request this password reset, please ignore this email.<br><br><br>From<br>AMS - KUCET<br>Developed & Deployed by Team Kaboom &copy; 2024";
		$mail->AltBody = 'HTML not supported';

		$mail->send();
		$statusMsg = "<div class='alert alert-success' role='alert' '>Email Sent Successfully!<br> Please, Check Your INBOX Or SPAM And Click The Link To Reset Your Password. <br> Note : The Link Is Only Vaild For 1 Hour.</div>";
	}catch (Exception $e) {
			$statusMsg = "<div class='alert alert-danger' role='alert' '>Message could not be sent. Mailer Error: ". $mail->ErrorInfo ."</div>";
	}
	return $statusMsg;
}

?>
