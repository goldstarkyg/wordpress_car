<?php
class LocationByLocationID extends BaseRequest {
	public function Init($location_id) {
		$parameters = array('pLocationID' => $location_id);
		return parent::DoPost(parent::AccountBaseAddr . parent::AccountLocationByLocationID, $parameters);
	}
}
?>