<?php
if (isset($_POST['makeoffer_hidden']) && $_POST['makeoffer_hidden'] == 'Y' && $this->is_set($_POST['makeoffer_first']) && $this->is_set($_POST['makeoffer_last']) && $this->is_set($_POST['makeoffer_phone']) && $this->is_set($_POST['makeoffer_email']) && $this->is_set($_POST['makeoffer_zip']) && $this->is_set($_POST['makeoffer_comments'])) {
	$loc_id = $this->settings['LocationID'];
	$inventory_id = $car->InventoryID;
	$first = $_POST['makeoffer_first'];
	$last = $_POST['makeoffer_last'];
	$phone = $_POST['makeoffer_phone'];
	$email = $_POST['makeoffer_email'];
	$zip = $_POST['makeoffer_zip'];
	$comments = $_POST['makeoffer_title'] . '\r\n' . $_POST['makeoffer_comments'];
    
    $to = $this->location->Email;
    $subject = rawurlencode("Car Info Request");
    $msg1 = "Someone has requested information about a car in your inventory, see below for details.";
    $msg2 = "This is a generated email from your website, please do not reply.";
    $body = rawurlencode("$msg1<br /><br />Inventory ID: $inventory_id<br />Name: $first $last<br />Email: $email<br />Phone: $phone<br />Comments: {$_POST['makeoffer_comments']}<br /><br />$msg2");

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
	<li><input type="text" name="makeoffer_first" id="first" placeholder="First Name" class="required" /></li>
	<li><input type="text" name="makeoffer_last" id="last" placeholder="Last Name" class="required" /></li>
	<li><input type="text" name="makeoffer_phone" id="phone" placeholder="Phone Number" class="required phone" /></li>
	<li><input type="text" name="makeoffer_email" id="email" placeholder="Email Address" class="required" /></li>
	<li><input type="text" name="makeoffer_zip" id="zip" placeholder="Zip Code" class="required zipcode" /></li>
	<li><textarea name="makeoffer_comments" id="comments" placeholder="Comments" rows="2" cols="20" class="required"></textarea></li>
	<li><input type="submit" value="Submit Your Request" /></li>
</ul>
<?php } ?>