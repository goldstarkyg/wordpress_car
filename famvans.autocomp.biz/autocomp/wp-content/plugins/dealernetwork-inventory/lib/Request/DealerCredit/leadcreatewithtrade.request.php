<?php
class LeadCreateWithTrade extends BaseRequest {
	public function Init($location_id, $inventory_id, $first_name, $last_name, $phone, $email, $zip, $comments, $trade_year, $trade_make, $trade_model, $trade_color, $trade_vin, $trade_mileage) {
		$parameters = array(
			'pLocationID' => $location_id,
			'pInventoryID' => $inventory_id,
			'pOriginID' => 2,
			'pFirst' => $first_name,
			'pLast' => $last_name,
			'pPhone' => $phone,
			'pEmail' => $email,
			'pZip' => $zip,
			'pComments' => $comments,
                        'pBusinessName' => '',
			'pTradeYear' => $trade_year,
			'pTradeMake' => $trade_make,
			'pTradeModel' => $trade_model,
			'pTradeColor' => $trade_color,
			'pTradeVIN' => $trade_vin,
			'pTradeMileage' => $trade_mileage
		);
		return parent::DoPost(parent::DealerCreditBaseAddr . parent::DealerCreditLeadCreateWithTrade, $parameters);
	}
}
?>
