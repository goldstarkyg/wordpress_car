<?php
require_once('SimpleRestClient.php');
require_once('Request/baserequest.class.php');
require_once('Request/Account/dealerwebsitesettingsbydealerid.request.php');

class Dealer {
	public $DealerID;
	public $Company;
	public $Website;
	public $Settings;
	
	public static function GetByDealerID($dealer_id) {
		$req = new DealerWebsiteSettingsByDealerID();
		$response = $req->Init($dealer_id);
		if ($response == null) return null;
		if ($response->xpath('//mErrorCode')[0] != 'Ok') return null;
		return self::PopulateFromXmlObject($response->xpath('//mItem')[0]);
	}
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new Dealer();
		try {
			$ret->DealerID = (int) $xml->xpath('.//Dealer/DealerID')[0];
			$ret->Company = (string) $xml->xpath('.//Dealer/Company')[0];
			$ret->Website = (string) $xml->xpath('.//Dealer/Website')[0];
			$ret->Settings = DealerWebsiteSettings::PopulateFromXmlObject($xml);
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}
	
}

class DealerWebsiteSettings {
	public $InventoryKeywords;
	public $InventoryDetail;
	public $DetailKeywords;
	public $DetailDescription;
	public $ShowConditionReport;
	public $ShowLeftMenuPanel;
	public $ShowWasPrice;
	public $ShowCompareLink;
	public $ShowPicturesLink;
	public $ShowTopMenu;
	public $ShowPendingCars;
	public $ShowMPG;
	public $ShowLoanCalculator;
	public $Kilometer;
	public $ShowVIN;
	public $NoPriceText;
	public $MondayHours;
	public $TuesdayHours;
	public $WednesdayHours;
	public $ThursdayHours;
	public $FridayHours;
	public $SaturdayHours;
	public $SundayHours;
	
	public static function PopulateFromXmlObject($xml) {
		$ret = new DealerWebsiteSettings();
		try {
			$ret->InventoryKeywords = (string) $xml->xpath('.//InventoryKeywords')[0];
			$ret->InventoryDetail = (string) $xml->xpath('.//InventoryDetail')[0];
			$ret->DetailKeywords = (string) $xml->xpath('.//DetailKeywords')[0];
			$ret->DetailDescription = (string) $xml->xpath('.//DetailDescription')[0];
			$ret->ShowConditionReport = (bool) $xml->xpath('.//ShowConditionReport')[0];
			$ret->ShowLeftMenuPanel = (bool) $xml->xpath('.//ShowLeftMenuPanel')[0];
			$ret->ShowWasPrice = (bool) $xml->xpath('.//ShowWasPrice')[0];
			$ret->ShowCompareLink = (bool) $xml->xpath('.//ShowCompareLink')[0];
			$ret->ShowPicturesLink = (bool) $xml->xpath('.//ShowPicturesLink')[0];
			$ret->ShowTopMenu = (bool) $xml->xpath('.//ShowTopMenu')[0];
			$ret->ShowPendingCars = (bool) $xml->xpath('.//ShowPendingCars')[0];
			$ret->ShowMPG = (bool) $xml->xpath('.//ShowMPG')[0];
			$ret->ShowLoanCalculator = (bool) $xml->xpath('.//ShowLoanCalculator')[0];
			$ret->Kilometer = (bool) $xml->xpath('.//Kilometer')[0];
			$ret->ShowVIN = (bool) $xml->xpath('.//ShowVIN')[0];
			$ret->NoPriceText = (string) $xml->xpath('.//NoPriceText')[0];
			$ret->MondayHours = (string) $xml->xpath('.//MondayHours')[0];
			$ret->TuesdayHours = (string) $xml->xpath('.//TuesdayHours')[0];
			$ret->WednesdayHours = (string) $xml->xpath('.//WednesdayHours')[0];
			$ret->ThursdayHours = (string) $xml->xpath('.//ThursdayHours')[0];
			$ret->FridayHours = (string) $xml->xpath('.//FridayHours')[0];
			$ret->SaturdayHours = (string) $xml->xpath('.//SaturdayHours')[0];
			$ret->SundayHours = (string) $xml->xpath('.//SundayHours')[0];			
			return $ret;
		} catch (Exception $ex) {}
		return null;
	}

}
?>