<?php
require_once('SimpleRestClient.php');
require_once('Request/baserequest.class.php');
require_once('Request/DealerCredit/leadcreate.request.php');
require_once('Request/DealerCredit/leadcreatewithtrade.request.php');
class Lead {
	public static function Create($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments) {
		$create = new LeadCreate();
		$xml = $create->Init($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments);
		try {
			return $xml->xpath('//mErrorCode')[0] == 'Ok';
		} catch (Exception $ex) {}
		return false;
	}
	
	public static function CreateWithTrade($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments, $trade_year, $trade_make, $trade_model, $trade_color, $trade_vin, $trade_mileage) {
		$create = new LeadCreateWithTrade();
		$xml = $create->Init($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments, $trade_year, $trade_make, $trade_model, $trade_color, $trade_vin, $trade_mileage);
		try {
			return $xml->xpath('//mErrorCode')[0] == 'Ok';
		} catch (Exception $ex) {}
		return false;
	}
}
?>