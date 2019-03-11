<?php
require_once('SimpleRestClient.php');
require_once('Request/baserequest.class.php');
require_once('Request/DealerInventory/getlistbylocationid.request.php');
require_once('Request/DealerInventory/inventoryregisterhit.request.php');
require_once('Request/Account/locationbylocationid.request.php');
require_once('Request/Account/dealerpartnerlinkbylocationid.request.php');
class Car {
	public $InventoryID;
	public $Location;
	public $Views;
	public $Category;
	public $New;
	public $StockNumber;
	public $Year;
	public $Make;
	public $Model;
	public $Trim;
	public $VIN;
	public $Engine;
	public $Transmission;
	public $ExteriorColor;
	public $ExteriorHex;
	public $InteriorColor;
	public $InteriorHex;
	public $Mileage;
	
	public $FuelType;
	public $Doors;
	public $Cylinders;
	public $DriveType;
	public $BodyStyle;
	public $Specifications;
	public $Equipment;
	public $OptionalEquipment;
	public $Description;
	public $WholesalePrice;
	public $InternetPrice;
	public $Price;
	public $Status;
	public $LotDate;
	public $ImageUrls;
	
	public $Featured;
	public $Special;
	public $CityMPG;
	public $HwyMPG;
	public $Condition;
	public $HasCarfax;
	public $HasAutoCheck;
	
	public $UpdatedOn;
	
	public function RegisterHit($ip_address) {
		$req = new InventoryRegisterHit();
		$response = $req->Init($this->InventoryID, $ip_address, 'WordPress');
	}
	
	public static function GetListByLocationID($location_id) {
		$req = new GetListbyLocationID();
		$response = $req->Init($location_id);
		if ($response == null) return null;
		if ($response->xpath('//mErrorCode')[0] != 'Ok') return null;
		$cars = array();
		$car_list = $response->xpath('//Car');
		while (list ( , $node) = each ($car_list)) {
			array_push($cars, self::PopulateFromXmlObject($node));
		}
		return count($cars) > 0 ? $cars : null;
	}
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new Car();
		try {
			$ret->InventoryID = (int) $xml->xpath('.//InventoryID')[0];
			$ret->Location = Location::PopulateFromXmlObject($xml);
			$ret->Views = (int) $xml->xpath('.//Views')[0];
			$ret->Category = (string) $xml->xpath('.//Category')[0];
			$ret->New = $xml->xpath('.//New')[0] == 'true';
			$ret->StockNumber = (string) $xml->xpath('.//StockNumber')[0];
			$ret->Year = (int) $xml->xpath('.//Year')[0];
			$ret->Make = (string) $xml->xpath('.//Make')[0];
			$ret->Model = (string) $xml->xpath('.//Model')[0];
			$ret->Trim = (string) $xml->xpath('.//Trim')[0];
			$ret->VIN = (string) $xml->xpath('.//VIN')[0];
			$ret->Engine = (string) $xml->xpath('.//Engine')[0];
			$ret->Transmission = (string) $xml->xpath('.//Transmission')[0];
			$ret->ExteriorColor = (string) $xml->xpath('.//ExteriorColor')[0];
			$ret->ExteriorHex = (string) $xml->xpath('.//ExteriorHex')[0];
			$ret->InteriorColor = (string) $xml->xpath('.//InteriorColor')[0];
			$ret->InteriorHex = (string) $xml->xpath('.//InteriorHex')[0];
			$ret->Mileage = (int) $xml->xpath('.//Mileage')[0];
			$ret->FuelType = (string) $xml->xpath('.//FuelType')[0];
			$ret->Doors = (int) $xml->xpath('.//Doors')[0];
			$ret->Cylinders = (int) $xml->xpath('.//CylinderNumber')[0];
			$ret->DriveType = (string) $xml->xpath('.//DriveType')[0];
			$ret->BodyStyle = (string) $xml->xpath('.//BodyStyle')[0];
			// SPEC
			$ret->Specifications = self::GetArray((string) $xml->xpath('.//Specification')[0]);
			$ret->Equipment = self::GetArray((string) $xml->xpath('.//Equipment')[0]);
			$ret->OptionalEquipment = self::GetArray((string) $xml->xpath('.//OptionalEquipment')[0]);
			$ret->WholesalePrice = (float) $xml->xpath('.//DealerWholesalePrice')[0];
			$ret->InternetPrice = (float) $xml->xpath('.//InternetPrice')[0];//number_format((float) $xml->xpath('.//InternetPrice')[0], 2);
			$ret->Price = (float) $xml->xpath('.//Price')[0];//number_format((float) $xml->xpath('.//Price')[0], 2);
			$ret->Description = (string) $xml->xpath('.//AdComments')[0];
			$ret->Status = (string) $xml->xpath('.//VehicleStatus')[0];
			$ret->LotDate = strtotime($xml->xpath('.//VehicleStatusDate')[0]);
			$ret->ImageUrls = array();
			$image_urls = $xml->xpath('.//ImageUrls')[0];
			if (strlen((string) $image_urls) > 0) {
				foreach($image_urls->xpath('.//string') as $image) {
					array_push($ret->ImageUrls, (string) $image);
				}
			}
			$ret->Featured = $xml->xpath('.//WebsiteFeatured')[0] == 'true';
			$ret->Special = $xml->xpath('.//WebsiteSpecial')[0] == 'true';
			$ret->CityMPG = (int) $xml->xpath('.//CityMPG')[0];
			$ret->HwyMPG = (int) $xml->xpath('.//HwyMPG')[0];
			$ret->Condition = ($ret->New) ? 'New' : 'Used';
			$ret->HasCarfax = $xml->xpath('.//Carfax')[0] == 'true';
			$ret->HasAutoCheck = $xml->xpath('.//HasAutoCheck')[0] == 'true';
			$update_date = (string) $xml->xpath('.//UpdatedOn')[0];
			if (strlen($update_date) <= 0)
				$update_date = (string) $xml->xpath('.//InsertedOn')[0];
			$ret->UpdatedOn = strtotime($update_date);
			
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}
	
	private static function GetArray($list) {
		$ret = array();
		if (strlen($list) > 0) {
			if (strpos($list, '</ul></li>')) {
				$list = preg_replace('/<li><b>(.+?)<\/b>/i', '', $list);
				$list = preg_replace('/<\/ul><\/li>/i', '', $list);
				$list = strip_tags(preg_replace('/<\/li>/i', ',', $list));
				$list = substr($list, 0, strlen($list) - 1);
			}
			$ret = explode(',', $list);
		}
		return $ret;
	}
}

class Location {
	public $LocationID;
	public $DealerID;
	public $LocationName;
	public $FirstName;
	public $LastName;
	public $Address;
	public $Address2;
	public $City;
	public $State;
	public $Zip;
	public $Phone;
	public $Email;
	
	public static function GetByLocationID($location_id) {
		$req = new LocationByLocationID();
		$response = $req->Init($location_id);
		if ($response == null) return null;
		if ($response->xpath('//mErrorCode')[0] != 'Ok') return null;
		return self::PopulateFromXmlObject($response->xpath('//mItem')[0]);
	}
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new Location();
		try {
			$ret->LocationID = (int) $xml->xpath('.//LocationID')[0];
			$ret->DealerID = (int) $xml->xpath('.//DealerID')[0];
			$ret->LocationName = (string) $xml->xpath('.//LocationName')[0];
			$ret->FirstName = (string) $xml->xpath('.//FirstName')[0];
			$ret->LastName = (string) $xml->xpath('.//LastName')[0];
			$ret->Address = (string) $xml->xpath('.//Address')[0];
			$ret->Address2 = (string) $xml->xpath('.//Address2')[0];
			$ret->City = (string) $xml->xpath('.//City')[0];
			$ret->State = (string) $xml->xpath('.//State')[0];
			$ret->Zip = (string) $xml->xpath('.//ZipCode')[0];
			$ret->Phone = (string) $xml->xpath('.//Phone')[0];
			$ret->Email = (string) $xml->xpath('.//Email')[0];
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}
}	

class DealerPartnerLink {
	public $CarfaxUser;
	
	public static function GetByLocationID($location_id) {
		$req = new DealerPartnerLinkByLocationID();
		$response = $req->Init($location_id);
		if ($response == null) return null;
		if ($response->xpath('.//mErrorCode')[0] != 'Ok') return null;
		return self::PopulateFromXmlObject($response->xpath('//mItem')[0]);
	}
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new DealerPartnerLink();
		try {
			$ret->CarfaxUser = (string) $xml->xpath('.//CarfaxUser')[0];
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}
}
?>