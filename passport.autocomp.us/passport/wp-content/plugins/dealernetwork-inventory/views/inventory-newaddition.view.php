<?php
if ($this->car_list != null) {
	if ($this->mobile_detect->isMobile()) {
		$template = $this->settings['NewAdditionTemplateMobile'];
		$css = $this->settings['NewAdditionTemplateCSSMobile'];
	} else {
		$template = $this->settings['NewAdditionTemplate'];
		$css = $this->settings['NewAdditionTemplateCSS'];
	}
?>
<div class="dn-inv-wrap">
<?php
	$sorted_list = $this->car_list;
	$this->quick_sort($sorted_list, 'LotDate');
	$sorted_list = array_reverse($sorted_list);
	$newaddition_list = array();
	
	$max = 5;
	if ($attributes != "" && array_key_exists("count", $attributes) && is_numeric($attributes["count"])) {
		$max = intval($attributes["count"]);
	}
	if ($max > count($sorted_list))
		$max = count($sorted_list);
	
	/*foreach($this->car_list as $car) {
		if ($car->Featured)
			array_push($newaddition_list, $car);
	}*/
	for ($x = 0; $x < $max; $x++) {
		array_push($newaddition_list, $sorted_list[$x]);
	}
	if (count($newaddition_list) == 0) {
		?>
		<p>No Vehicles Found</p>
		<?php
	} else {
		if ($template != null) {
			echo '<style type="text/css" scoped>' . $css . '</style>';
			echo $this->parse_list_template($template, $newaddition_list, array ('[newadditionlist-count]' => count($newaddition_list)), false);
		}
	}
?>
</div>
<?php } ?>