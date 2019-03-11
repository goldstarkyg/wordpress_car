<?php
if (isset($_POST['requestinfo_hidden']) && $_POST['requestinfo_hidden'] == 'Y' && $this->is_set($_POST['requestinfo_first']) && $this->is_set($_POST['requestinfo_last']) && $this->is_set($_POST['requestinfo_phone']) && $this->is_set($_POST['requestinfo_email']) && $this->is_set($_POST['requestinfo_zip']) && $this->is_set($_POST['requestinfo_comments'])) {
	$loc_id = $this->settings['LocationID'];
	$inventory_id = $car->InventoryID;
	$first = $_POST['requestinfo_first'];
	$last = $_POST['requestinfo_last'];
	$phone = $_POST['requestinfo_phone'];
	$email = $_POST['requestinfo_email'];
	$zip = $_POST['requestinfo_zip'];
	$comments = $_POST['requestinfo_title'] . '\r\n' . $_POST['requestinfo_comments'];
    
    $to = $this->location->Email;
    $subject = rawurlencode("Car Info Request");
    $msg1 = "Someone has requested information about a car in your inventory, see below for details.";
    $msg2 = "This is a generated email from your website, please do not reply.";
    $body = rawurlencode("$msg1<br /><br />Stock Number: {$car->StockNumber}<br />Name: $first $last<br />Email: $email<br />Phone: $phone<br />Comments: {$_POST['requestinfo_comments']}<br /><br />$msg2");

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
    
	if (Lead::Create($loc_id, $inventory_id, $first, $last, $phone, $email, $zip, $comments)) {
		?>
		<h5>Thank You!</h5>
		<p style="text-align:center;">We have received your request, and we will respond to your inquiry as quickly as possible.</p>
	<?php } else { ?>
	<p style="text-align:center;">We were unable to submit your inquiry. Please try again later.</p>
<?php }} else { ?>
<ul>
	<li><input type="text" name="requestinfo_first" id="first" placeholder="First Name" class="required" /></li>
	<li><input type="text" name="requestinfo_last" id="last" placeholder="Last Name" class="required" /></li>
	<li><input type="text" name="requestinfo_phone" id="phone" placeholder="Phone Number" class="required phone" /></li>
	<li><input type="text" name="requestinfo_email" id="email" placeholder="Email Address" class="required" /></li>
	<li><input type="text" name="requestinfo_zip" id="zip" placeholder="Zip Code" class="required zipcode" /></li>
	<li><textarea name="requestinfo_comments" id="comments" placeholder="Comments" rows="2" cols="20" class="required"></textarea></li>
	<li><input type="submit" value="Submit Your Request" /></li>
</ul>
<?php } ?>