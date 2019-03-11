<?php
if ($this->car_list != null) {
	if ($this->mobile_detect->isMobile()) {
		$template = $this->settings['BestPriceTemplateMobile'];
		$css = $this->settings['BestPriceTemplateCSSMobile'];
	} else {
		$template = $this->settings['BestPriceTemplate'];
		$css = $this->settings['BestPriceTemplateCSS'];
	}
?>
<div class="dn-inv-wrap">
<?php
	$internet = false;
	if ($attributes != "" && array_key_exists("price", $attributes) && strtolower($attributes["price"]) == "internet")
		$internet = true;
	$sorted_list = array();
	foreach ($this->car_list as $car) {
		if (!$internet && $car->Price > 0)
			array_push($sorted_list, $car);
		if ($internet && $car->InternetPrice > 0)
			array_push($sorted_list, $car);
	}
	
	$this->quick_sort($sorted_list, ($internet ? 'InternetPrice' : 'Price'));
	//$sorted_list = array_reverse($sorted_list);
	$bestprice_list = array();
	
	$max = 5;
	if ($attributes != "" && array_key_exists("count", $attributes) && is_numeric($attributes["count"])) {
		$max = intval($attributes["count"]);
	}
	if ($max > count($sorted_list))
		$max = count($sorted_list);
	
	/*foreach($this->car_list as $car) {
		if ($car->Featured)
			array_push($bestprice_list, $car);
	}*/
	for ($x = 0; $x < $max; $x++) {
		array_push($bestprice_list, $sorted_list[$x]);
	}
	if (count($bestprice_list) == 0) {
		?>
		<p>No Vehicles Found</p>
		<?php
	} else {
		if ($template != null) {
			echo '<style type="text/css" scoped>' . $css . '</style>';
			echo $this->parse_list_template($template, $bestprice_list, array ('[bestpricelist-count]' => count($bestprice_list)), false);
		}
	}
?>
</div>
<?php } ?>