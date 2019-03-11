<?php
class GetListByLocationID extends BaseRequest {
	public function Init($location_id) {
		$parameters = array('pLocationID' => $location_id);
		return parent::DoPost(parent::DealerInventoryBaseAddr . parent::DealerInventoryGetListByLocationID, $parameters);
	}
}
?>