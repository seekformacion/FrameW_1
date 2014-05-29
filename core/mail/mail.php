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

function sendM($from,$fromN,$to,$toN,$subject,$message,$plain,$conf,$vconf){
include("/www/$conf");

if($conf!='mail2.php'){
$mail->Username = $from; 
}

$mail->Encoding = 'quoted-printable';


if((array_key_exists('LU-1', $vconf))&&(array_key_exists('LU-2', $vconf))){
	$LU1=$vconf['LU-1'];$LU2=$vconf['LU-2'];
$mail->addCustomHeader("List-Unsubscribe","<mailto:$LU1>, <$LU2>");
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



function verifyEmail($toemail, $fromemail, $getdetails = false){
	$email_arr = explode("@", $toemail);
	$domain = array_slice($email_arr, -1);
	$domain = $domain[0];

	// Trim [ and ] from beginning and end of domain string, respectively
	$domain = ltrim($domain, "[");
	$domain = rtrim($domain, "]");

	if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
		$domain = substr($domain, strlen("IPv6") + 1);
	}

	$mxhosts = array();
	if( filter_var($domain, FILTER_VALIDATE_IP) )
		$mx_ip = $domain;
	else
		
		echo "\n_________________\n"; 
		echo "\n$domain\n";
		print_r(getmxrr($domain, $mxhosts, $mxweight));
	    echo "\n_________________\n"; 	
		print_r($mxhosts);
	    echo "\n_________________\n";
	

	if(!empty($mxhosts) ){
		$mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
		//$mx_ip = $mxhosts[0];
		echo $mx_ip;
	    echo "\n_________________\n";
	
	}else {
		if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
			$record_a = dns_get_record($domain, DNS_A);
		}
		elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
			$record_a = dns_get_record($domain, DNS_AAAA);
		}

		if( !empty($record_a) )
			$mx_ip = $record_a[0]['ip'];
		else {

			$result   = "invalid";
			$details .= "No suitable MX records found.";

			return ( (true == $getdetails) ? array($result, $details) : $result );
		}
	}
    
	
	
	$details="";
	$connect = @fsockopen($mx_ip, 25); 
	if($connect){ 
		if(ereg("^220", $out = fgets($connect, 1024))){ 
			fputs ($connect , "HELO publiactive.es\r\n"); 
			$out = fgets ($connect, 1024);
			$details .= $out."\n";
 
			fputs ($connect , "MAIL FROM: <$fromemail>\r\n"); 
			$from = fgets ($connect, 1024); 
			$details .= $from."\n";

			fputs ($connect , "RCPT TO: <$toemail>\r\n"); 
			$to = fgets ($connect, 1024);
			$details .= $to."\n";

			fputs ($connect , "QUIT"); 
			fclose($connect);

			if(!ereg("^250", $from) || !ereg("^250", $to)){
				$result = "invalid"; 
			}
			else{
				$result = "valid";
			}
		} 
	}
	else{
		$result = "invalid";
		$details .= "Could not connect to server";
	}
	if($getdetails){
		return array($result, $details);
	}
	else{
		return $result;
	}
}
?>