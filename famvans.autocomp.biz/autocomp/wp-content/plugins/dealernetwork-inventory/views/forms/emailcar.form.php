<?php
if (isset($_POST['emailcar_hidden']) && $_POST['emailcar_hidden'] == 'Y' && $this->is_set($_POST['emailcar_email1']) && $this->is_set($_POST['emailcar_email'])) {

	$loc_id = $this->settings['LocationID'];
	$inventory_id = $car->InventoryID;
	$email1 = $_POST['emailcar_email1'];
	$email2 = $_POST['emailcar_email2'];
	$email3 = $_POST['emailcar_email3'];
	$email = $_POST['emailcar_email'];
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL) && filter_var($email1, FILTER_VALIDATE_EMAIL) && (!$this->is_set($email2) || filter_var($email2, FILTER_VALIDATE_EMAIL)) && (!$this->is_set($email3) || filter_var($email3, FILTER_VALIDATE_EMAIL))) {
		
		ob_start();
		$this->parse_detail_template($this->settings['EmailSubjectTemplate'], $car, array('[email-from]' => $email));
		$subject = ob_get_contents();
		ob_end_clean();
		
		ob_start();
		$this->parse_detail_template($this->settings['EmailBodyTemplate'], $car, array('[email-from]' => $email));
		$body = ob_get_contents();
		ob_end_clean();
		
		$body .= '<p style="text-align:center;">&copy; ' . date('Y', time()) . ' <a href="http://www.dealernetwork.com/" target="_blank">DealerNetwork.com</a>. All rights reserved.</p>';
		
        $recipients = array();
        $recipients[] = $email1;
		//$to = $email1;
//		if ($email2 != '') $to .= "," . $email2;
//		if ($email3 != '') $to .= "," . $email3;
        if ($email2 != '') $recipients[] = $email2;
        if ($email3 != '') $recipients[] = $email3;
        
        $subject = rawurlencode($subject);
        $body = rawurlencode($body);
        
//        $msg1 = "Someone has requested information about a car in your inventory, see below for details.";
//        $msg2 = "This is a generated email from your website, please do not reply.";
//        $body = rawurlencode("$msg1<br /><br />Inventory ID: $inventory_id<br />Name: $first $last<br />Email: $email<br />Phone: $phone<br />Comments: {$_POST['requestinfo_comments']}<br /><br />$msg2");

        $curl = curl_init();
        $emailFailed = false;
        foreach($recipients as $to)
        {
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => "http://dealerclick.net/Dealerclick/requestReceiver?type=send-email&to=$to&cc=&bcc=&subject=$subject&body=$body&locationID=2927"
            ));
            if (!$res = curl_exec($curl))
                $emailFailed = true;
        }
        

        curl_close($curl);
		
//		$headers = 'From: noreply@dealernetwork.com' . "\r\n" .
//				   'Reply-To: ' . $email . "\r\n" .
//				   'X-Mailer: PHP/' . phpversion();
//		$headers .= 'MIME-Version: 1.0' . "\r\n";
//		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//		ini_set ( "SMTP", "hosting.mitech1.com" ); 
		if (!$emailFailed) {
		?>
		<h5>Thank You!</h5>
		<p style="text-align:center;">We have shared this vehicle.</p>
		<?php return;} else { ?>
		<p style="text-align:center;">We were unable to share this vehicle. Please try again later.</p>
		<?php return;}
	}	
} ?>
<ul>
	<li><input type="text" name="emailcar_email1" id="email1" placeholder="Email 1" class="required" /></li>
	<li><input type="text" name="emailcar_email2" id="email2" placeholder="Email 2" /></li>
	<li><input type="text" name="emailcar_email3" id="email3" placeholder="Email 3" /></li>
	<li><input type="text" name="emailcar_email" id="email" placeholder="Your Email" class="required" /></li>
	<li><input type="submit" value="Email This Ad" /></li>
</ul>