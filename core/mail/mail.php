<?php

includeCORE('mail/smtp');
includeCORE('mail/sasl');


  
include('/www/mail.php');


function sendM($from,$to,$subject,$message){
include('/www/mail.php');  	
$smtp->user=$from;



if($smtp->SendMessage($from, array($to), array("From: $from","To: $to",	"Subject: $subject","Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")),	"$message"))
{echo "Message sent to $to OK.\n";}else{echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";};	
	
}


?>