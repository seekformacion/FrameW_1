<?php

includeCORE('mail/smtp');
includeCORE('mail/sasl');


  
include('/www/mail.php');


function utt8($str){
$str="=?utf-8?b?".base64_encode($str)."?=";	
return $str;	
}

function sendM($from,$fromN,$to,$toN,$subject,$message){
include('/www/mail.php');  	
$smtp->user=$from;

$fromN=utt8($fromN);
$toN=utt8($toN);
$subject=utt8($subject);

if($smtp->SendMessage(	$from, 
						array($to), 
						array(
						
							"MIME-Version: 1.0",
							"Content-Type: text/html; charset=UTF-8;",
							//" format=flowed",
							"Content-Transfer-Encoding: 8bit",
							
							"From:$fromN <$from>","To:$toN <$to>",
							"Subject: $subject",
							"X-Sender: $from",
							"User-Agent: Roundcube Webmail/0.9.5",					
							"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")),
							"$message"
							
							))
{echo "Message sent to $to OK.\n";}else{echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";};	
	
}

?>