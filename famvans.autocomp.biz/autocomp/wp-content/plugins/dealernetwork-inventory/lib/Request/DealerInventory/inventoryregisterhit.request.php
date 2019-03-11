<?php
class InventoryRegisterHit extends BaseRequest {
	public function Init($inventory_id, $ip_address, $by) {
		$parameters = array('pInventoryID' => $inventory_id, 'pIpAddress' => $ip_address, 'pBy' => $by);
		return parent::DoPost(parent::DealerInventoryBaseAddr . parent::DealerInventoryRegisterHit, $parameters);
	}
}
?>