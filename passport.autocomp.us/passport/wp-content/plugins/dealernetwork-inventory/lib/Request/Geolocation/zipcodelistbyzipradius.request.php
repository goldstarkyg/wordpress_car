<?php
class ZipCodeListByZipRadius extends BaseRequest {
	public function Init($zipcode, $radius) { 
		$parameters = array('pZipcode' => $zipcode, 'pRadius' => $radius);
		return parent::DoPost(parent::GeolocationBaseAddr . parent::GeolocationZipCodeListByZipRadius, $parameters);
	}
}
?>