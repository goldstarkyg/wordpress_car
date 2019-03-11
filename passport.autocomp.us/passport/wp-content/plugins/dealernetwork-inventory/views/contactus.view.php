<?php
 
	if (isset($_POST['contactus_hidden']) && $_POST['contactus_hidden'] == 'Y' && $this->is_set($_POST['contact-fname']) && $this->is_set($_POST['contact-lname']) && $this->is_set($_POST['contact-email']) && $this->is_set($_POST['contact-phone']) && $this->is_set($_POST['contact-subject'])) {
		$loc_id = $this->settings['LocationID'];
		$first_name = $_POST['contact-fname'];
		$last_name = $_POST['contact-lname'];
		$phone = $_POST['contact-phone'];
		$email = $_POST['contact-email'];
		$zip = "0";
		$comments = $_POST['contact-comments'];
		$comments .= "\r\nSubject: " . $_POST['contact-subject'];
        
        $to = $this->location->Email;
        $subject = rawurlencode("Contact Request");
        $msg1 = "Someone has submitted a contact form on your website, see below for details.";
        $msg2 = "This is a generated email from your website, please do not reply.";
        $body = rawurlencode("$msg1<br /><br />Name: $first_name $last_name<br />Email: $email<br />Phone: $phone<br />Comments: {$_POST['contact-comments']}<br /><br />$msg2");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "http://dealerclick.net/Dealerclick/requestReceiver?type=send-email&to=$to&cc=&bcc=&subject=$subject&body=$body&locationID=2927"
        ));
        $res = curl_exec($curl);

    //    if ($res = curl_exec($curl))
    //    {
    //        if ($res == "ResultMessage [resultCode=OK, desc=]")
    //        {
    //            //???
    //        }
    //    }
        curl_close($curl);
        
		if (Lead::Create($loc_id, 0, $first_name, $last_name, $phone, $email, $zip, $comments)) {
		?>
		<h4 style="text-align:center;">Thank You!</h4>
		<p style="text-align:center;">We have received your request, and we will respond to your inquiry as quickly as possible.</p>
		<?php } else { ?>
			<p style="text-align:center;">There was an error submitting your request. Please try again later.</p>
		<?php }
	} else {
?>
<form method="post" action="<?php echo $this->current_url; ?>" class="validate-me">
	<input type="hidden" name="contactus_hidden" value="Y">
	<div id="dn-trade">
		<div id="dn-trade-contact">
			<ul>
				<li>
					<label for="contact-fname">First Name: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-fname" name="contact-fname" class="required" tabindex="11" />
				</li>
				<li>
					<label for="contact-email">Email: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-email" name="contact-email" class="required" tabindex="13" />
				</li>
				<li>
					<label for="contact-subject">Subject: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-subject" name="contact-subject" class="required" tabindex="15" />
				</li>
			</ul>
			<ul>
				<li>
					<label for="contact-lname">Last Name: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-lname" name="contact-lname" class="required" tabindex="12" />
				</li>
				<li>
					<label for="contact-phone">Phone: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-phone" name="contact-phone" class="required phone" tabindex="14" />
				</li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<div id="dn-trade-comments">
			<ul>
				<li>
					<label for="contact-comments">Message:</label>
					<textarea id="contact-comments" name="contact-comments" tabindex="17"></textarea>
				</li>
				<li style="text-align:center;">
					<input type="submit" value="Submit" tabindex="18" />
				</li>
			</ul>
			<div style="clear:both;"></div>
		</div>
	</div>
</form>
<?php } ?>
