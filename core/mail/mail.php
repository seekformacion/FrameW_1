<?php

includeCORE('mail/smtp');
includeCORE('mail/sasl');


  
include('/www/mail.php');


function sendM($from,$fromN,$to,$toN,$subject,$message){
include('/www/mail.php');  	
$smtp->user=$from;

if($smtp->SendMessage(	$from, 
						array($to), 
						array(
							"From:$fromN <$from>","To:$toN <$to>",
							"Subject: $subject",
							"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")),
							"MIME-Version: 1.0",
							"Content-type: text/html; charset=utf-8",
							"$message"
							
							))
{echo "Message sent to $to OK.\n";}else{echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";};	
	
}


?>