<?php
require 'includes/mail/PHPMailerAutoload.php';

class sendMail
{
	function sendEmail($to,$subject,$body)
	{
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'deepak.kabbur@weboniselab.com';                 // SMTP username
		$mail->Password = 'deeps123';                           // SMTP password
		$mail->SMTPSecure = 'tls';
		$mail->From = 'admin@couriersystem.com';
		$mail->FromName = 'Courier System';
		$mail->addAddress($to);     // Add a recipient
		$mail->isHTML(true);  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = strip_tags($body);
		if(!$mail->send()) 
		{
	    	echo 'Message could not be sent.';
	    	echo 'Mailer Error: ' . $mail->ErrorInfo;
		} 
		else 
		{
	    	echo 'Message has been sent';
		}
	}
}

?>