<?php
if (isset($_GET['id'])) {
	if (is_numeric($_GET['id'])) {
		foreach ($this->car_list as $x) {
			if ($x->InventoryID == $_GET['id'])
				$car = $x;
		}
	}
}
 
	if (isset($_POST['valuetrade_hidden']) && $_POST['valuetrade_hidden'] == 'Y' && $this->is_set($_POST['trade-mileage']) && $this->is_set($_POST['trade-year']) && $this->is_set($_POST['trade-make']) && $this->is_set($_POST['trade-model']) && $this->is_set($_POST['trade-interiorcolor']) && $this->is_set($_POST['trade-exteriorcolor']) && $this->is_set($_POST['trade-payoff']) && $this->is_set($_POST['contact-fname']) && $this->is_set($_POST['contact-lname']) && $this->is_set($_POST['contact-email']) && $this->is_set($_POST['contact-phone']) && $this->is_set($_POST['contact-zipcode'])) {
		$loc_id = $this->settings['LocationID'];
		$inv_id = (isset($car) ? $car->InventoryID : 0);
		$first_name = $_POST['contact-fname'];
		$last_name = $_POST['contact-lname'];
		$phone = $_POST['contact-phone'];
		$email = $_POST['contact-email'];
		$zip = $_POST['contact-zipcode'];
		$comments = $_POST['contact-comments'];
		$trade_year = $_POST['trade-year'];
		$trade_make = $_POST['trade-make'];
		$trade_model = $_POST['trade-model'];
		$trade_color = $_POST['trade-exteriorcolor'];
		$trade_vin = $_POST['trade-vin'];
		$trade_mileage = $_POST['trade-mileage'];
		$comments .= "\r\nTrade Condition: " . $_POST['trade-condition'];
		$comments .= "\r\nCondition Comments: " . $_POST['trade-conditioncomments'];
		$comments .= "\r\nInterior Color: " . $_POST['trade-interiorcolor'];
		$comments .= "\r\nPay Off Balance: $" . $_POST['trade-payoff'];
		$comments .= "\r\nPurchase Timeframe: " . $_POST['contact-timeframe'];

        $to = $this->location->Email;
        $subject = rawurlencode("Contact Request");
        $msg1 = "Someone has submitted a trade appraisal form on your website, for more info view it on your DealerNetwork account.";
        $msg2 = "This is a generated email from your website, please do not reply.";
        $body = rawurlencode("$msg1<br /><br />Name: $first_name $last_name<br />Email: $email<br />Phone: $phone<br />$msg2");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "http://dealerclick.net/Dealerclick/requestReceiver?type=send-email&to=$to&cc=&bcc=&subject=$subject&body=$body&locationID=2927"
        ));
        $res = curl_exec($curl);

		if (Lead::CreateWithTrade($loc_id, $inv_id, $first_name, $last_name, $phone, $email, $zip, $comments, $trade_year, $trade_make, $trade_model, $trade_color, $trade_vin, $trade_mileage)) {
		?>
		<h4 style="text-align:center;">Thank You!</h4>
		<p style="text-align:center;">We have received your request, and we will respond to your inquiry as quickly as possible.</p>
		<?php } else { ?>
			<p style="text-align:center;">There was an error submitting your request. Please try again later.</p>
		<?php }
	} else {
?>
<form method="post" action="<?php echo $this->current_url; ?>" class="validate-me">
	<input type="hidden" name="valuetrade_hidden" value="Y">
	<div id="dn-trade">
		<?php 
		if (isset($car)) {
		?>
		<div id="dn-trade-car">
			<h4>Selected Vehicle</h4>
			<?php if (count($car->ImageUrls) > 0) { ?>
			<div id="dn-trade-car-left">
				<img src="<?php echo $car->ImageUrls[0]; ?>" alt="<?php echo $car->Year . ' ' . $car->Make . ' ' . $car->Model; ?>" />
			</div>
			<?php } ?>
			<div id="dn-trade-car-right">
				<h5><?php echo "$car->Year $car->Make $car->Model"; ?></h5>
				<p><?php echo $car->Engine; ?></p>
				<p style="font-weight: bold;"><?php if ($car->InternetPrice > 0) {
					echo "Price: $car->InternetPrice";
				} else if ($car->Price > 0) {
					echo "Price: $car->Price";
				} else {
					echo "Call for pricing";
				}?>
				</p>
			</div>
			<div style="clear:both;"></div>
		</div>
		<?php } ?>
		<div id="dn-trade-tradecar">
			<h4 class="hhhv">Your Vehicle Information</h4>
			<ul>
				<li>
					<label for="trade-vin">VIN:</label>
					<input type="text" id="trade-vin" name="trade-vin" tabindex="1" />
				</li>
				<li>
					<label for="trade-year">Year/Make: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-year" name="trade-year" class="required year" tabindex="3" />
					<input type="text" id="trade-make" name="trade-make" class="required" tabindex="4" />
				</li>
				<li>
					<label for="trade-condition">Condition:</label>
					<select id="trade-condition" name="trade-condition" tabindex="6">
						<option>Excellent Condition</option>
						<option>Fair Condition</option>
						<option>Poor Condition</option>
					</select>
				</li>
				<li>
					<label for="trade-conditioncomments">Condition Comments:</label>
					<textarea id="trade-conditioncomments" name="trade-conditioncomments" tabindex="8"></textarea>
				</li>
			</ul>
			<ul>
				<li>
					<label for="trade-mileage">Mileage: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-mileage" name="trade-mileage" class="required" tabindex="2" />
				<li>
				</li>
					<label for="trade-model">Model: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-model" name="trade-model" class="required" tabindex="5" />
				</li>
				<li>
					<label for="trade-interiorcolor">Interior Color: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-interiorcolor" name="trade-interiorcolor" class="required" tabindex="7" />
				</li>
				<li>
					<label for="trade-exteriorcolor">Exterior Color: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-exteriorcolor" name="trade-exteriorcolor" class="required" tabindex="9" />
				</li>
				<li>
					<label for="trade-payoff">Pay Off Balance: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="trade-payoff" name="trade-payoff" class="required currency" tabindex="10" />
				</li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<div id="dn-trade-contact">
			<h4 class="hhhv">Your Contact Information</h4>
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
					<label for="contact-zipcode">Zipcode: <span style="color:#ff0000;font-weight:bold;">*</span></label>
					<input type="text" id="contact-zipcode" name="contact-zipcode" class="required zip" tabindex="15" />
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
				<li>
					<label for="contact-timeframe">Purchase Timeframe:</label>
					<select id="contact-timeframe" name="contact-timeframe" tabindex="16">
						<option>Within the next 24 hours</option>
						<option>Within the next 72 hours</option>
						<option>Within the next 2 weeks</option>
						<option>Within the next month</option>
						<option>I am undecided</option>
					</select>
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
