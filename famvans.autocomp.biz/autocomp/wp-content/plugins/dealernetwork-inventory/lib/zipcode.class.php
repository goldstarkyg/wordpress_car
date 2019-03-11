<?php
require_once('SimpleRestClient.php');
require_once('Request/baserequest.class.php');
require_once('Request/Geolocation/zipcodelistbyzipradius.request.php');

class ZipCode {
	public $Zipcode;
	public $Latitude;
	public $Longitude;
	public $City;
	public $State;
	public $County;
	
	public static function ListByZipRadius($zipcode, $radius) {
		$req = new ZipCodeListByZipRadius();
		$response = $req->Init($zipcode, $radius);
		if ($response == null) return null;
		if ($response->xpath('//mErrorCode')[0] != 'Ok') return null;
		$zips = array();
		$zip_list = $response->xpath('//ZipCode');
		while (list ( , $node) = each ($zip_list)) {
			array_push($zips, self::PopulateFromXmlObject($node));
		}
		return count($zips) > 0 ? $zips : null;
	}	
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new ZipCode();
		try {
			$ret->Zipcode = (string) $xml->xpath('.//Zipcode')[0];
			$ret->Latitude = (string) $xml->xpath('.//Latitude')[0];
			$ret->Longitude = (string) $xml->xpath('.//Longitude')[0];
			$ret->City = (string) $xml->xpath('.//City')[0];
			$ret->State = (string) $xml->xpath('.//State')[0];
			$ret->County = (string) $xml->xpath('.//County')[0];
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}
}
?>