<?php
class BaseRequest { 
	protected $BaseAddr = "http://services.dealernetwork.com";
	
	// dealerinventory
	const DealerInventoryBaseAddr = 'http://services.dealernetwork.com/DealerInventory.asmx';
	const DealerInventoryGetListByLocationID = '/GetListByLocationID';
	const DealerInventoryRegisterHit = '/InventoryRegisterHit';
	
	// account
	const AccountBaseAddr = 'http://services.dealernetwork.com/Account.asmx';
	const AccountDealerPartnerLinkByLocationID = '/DealerPartnerLinkByLocationID';
	const AccountDealerWebsiteSettingsByDealerID = '/DealerWebsiteSettingsByDealerID';
	const AccountLocationByLocationID = '/LocationByLocationID';
	
	// dealercredit
	const DealerCreditBaseAddr = 'http://services.dealernetwork.com/DealerCredit.asmx';
	const DealerCreditLeadCreate = '/LeadCreate';
	const DealerCreditLeadCreateWithTrade = '/LeadCreateWithTrade';
	
	// geolocation
	const GeolocationBaseAddr = 'http://services.dealernetwork.com/Geolocation.asmx';
	const GeolocationZipCodeListByZipRadius = '/ZipCodeListByZipRadius';
	
	protected function DoPost($url, $parameters) {

		error_reporting(E_ERROR | E_PARSE);
		try {
			$parameters['pXml'] = 'true';
			$xml=null;
			$restclient=null;
			$result=null;
			
			$cert_file=null;//Path to cert file 
			$key_file=null;//Path to private key
			$key_password=null;//Private key passphrase
			$curl_opts=null;//Array to set additional CURL options or override the default options of the SimpleRestClient
			$user_agent = "PHP Sample Rest Client";
			$restclient = new SimpleRestClient($cert_file, $key_file, $key_password, $user_agent, $curl_opts);
			$restclient->postWebRequest($url, $parameters);
			$response = $restclient->getWebResponse();
			$xml = simplexml_load_string($response);
			if ($xml !== false)
				return $xml;
		} catch (Exception $ex) {}
		return null;
	}
}
?>