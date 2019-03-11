<?php
if ($this->car_list != null) {
	if ($this->mobile_detect->isMobile()) {
		$template = $this->settings['SingleOfferTemplateMobile'];
		$css = $this->settings['SingleOfferTemplateCSSMobile'];
	} else {
		$template = $this->settings['SingleOfferTemplate'];
		$css = $this->settings['SingleOfferTemplateCSS'];
	}
?>
<div class="dn-inv-wrap">
<?php
	if ($attributes == "" || !array_key_exists("id", $attributes) || !is_numeric($attributes["id"]))
		return;
	foreach ($this->car_list as $car) {
		if ($car->InventoryID == intval($attributes["id"]))
			$individual_car = $car;
	}
	
	if (!isset($individual_car)) {
		?>
		<p>No Vehicles Found</p>
		<?php
	} else {
		if ($template != null) {
			echo '<style type="text/css" scoped>' . $css . '</style>';
			echo $this->parse_detail_template($template, $individual_car);
		}
	}
?>
</div>
<?php } ?>