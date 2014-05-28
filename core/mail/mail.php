<?php

/*
includeCORE('mail/smtp');
includeCORE('mail/sasl');


  
include('/www/mail.php');
*/

function utt8($str){
$str="=?utf-8?b?".base64_encode($str)."?=";	
return $str;	
}

function sendM($from,$fromN,$to,$toN,$subject,$message,$plain,$conf){
include("/www/$conf");

if($conf!='mail2.php'){
$mail->Username = $from; 
}

$mail->From = $from;
$mail->FromName = $fromN;
$mail->addAddress($to, $toN);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = $plain;

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
return FALSE;
}

return TRUE;// 'Message has been sent';


  	

	
}

?>