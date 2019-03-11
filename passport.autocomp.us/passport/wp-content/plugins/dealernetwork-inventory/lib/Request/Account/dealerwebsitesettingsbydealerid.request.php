<?php
class DealerWebsiteSettingsByDealerID extends BaseRequest {
	public function Init($dealer_id) {
		$parameters = array('pDealerID' => $dealer_id);
		return parent::DoPost(parent::AccountBaseAddr . parent::AccountDealerWebsiteSettingsByDealerID, $parameters);
	}
}
?>