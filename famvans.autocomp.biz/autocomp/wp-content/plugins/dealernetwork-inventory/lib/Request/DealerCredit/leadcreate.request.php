<?php
class LeadCreate extends BaseRequest {
	public function Init($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments) {
		$parameters = array(
			'pLocationID' => $location_id,
			'pInventoryID' => $inventory_id,
			'pOriginID' => 2,
			'pFirst' => $first_name,
			'pLast' => $last_name,
			'pPhone' => $phone,
			'pEmail' => $email,
			'pZip' => $zip,
			'pComments' => $comments
		);
		return parent::DoPost(parent::DealerCreditBaseAddr . parent::DealerCreditLeadCreate, $parameters);
	}
}
?>