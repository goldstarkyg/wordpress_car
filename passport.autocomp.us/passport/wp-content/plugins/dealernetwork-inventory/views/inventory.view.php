<img/>
<?php

// get options and car list
if ($this->car_list == null) {
	// no list found
	?>
	<div id="dn-inv-wrap">
		<div>
			No vehicles found
		</div>	
	</div>
	<?php
	return;
}

// templates
if ($this->mobile_detect->isMobile()) {
	$list_template = $this->settings['ListTemplateMobile'];
	$list_css = $this->settings['ListTemplateCSSMobile'];
	$detail_template = $this->settings['DetailTemplateMobile'];
	$detail_css = $this->settings['DetailTemplateCSSMobile'];
} else {
	$list_template = $this->settings['ListTemplate'];
	$list_css = $this->settings['ListTemplateCSS'];
	$detail_template = $this->settings['DetailTemplate'];
	$detail_css = $this->settings['DetailTemplateCSS'];
}

// check for inventory id, if it exists, display detail page
$car = $this->get_detail_car();
if (isset($car)) {
	?>
	<div id="dn-inv-wrap">
		<?php
			$car->RegisterHit($_SERVER['REMOTE_ADDR']);
			echo '<style type="text/css" scoped>' . $detail_css . '</style>';
			echo $this->parse_detail_template($detail_template, $car);
		?>
	</div>
	<?php	
	return;
}

$display_list = $this->car_list;

// SEARCH
if (isset($_GET[$this->filter_keys['search']])) {
	$search_query = explode(' ', $_GET[$this->filter_keys['search']]);
	// Find year, if it is included in the search query
	foreach ($search_query as $query) {
		if (is_numeric($query) && strlen($query) == 4) {
			$year = $query;
			unset($search_query[array_search($year, $search_query)]);
			$search_query = array_values($search_query);
		}
	}
	$new_list = array();
	// Search cars
	foreach($display_list as $car) {
		if (isset($year)) {
			if ($car->Year != $year)
				$car = null;
		}
		if ($car != null) {
			if (count($search_query) > 0) {
				foreach($search_query as $query) {
					if (stripos($car->Make, $query) !== false || stripos($car->Model, $query) !== false)
						array_push($new_list, $car);
				}
			} else {
				array_push($new_list, $car);
			}
		}
	}
	// set the display list
	$display_list = $new_list;
	unset($new_list);
}
foreach ($_GET as $key => $value) {
	// regular filters
	if (array_key_exists($key, $this->filter_relations) && $value != "") {
		$new_list = array();
		foreach ($display_list as $car) {
			$v = $this->filter_relations[$key];
			if ($car->$v == $value)
				array_push($new_list, $car);
		}
		$display_list = $new_list;
	} else { // range filters
		foreach ($this->filter_range_keys as $ak=>$av) {
			if (in_array($key, $av)) {
				$filter_range_key = $ak;
			}
		}
		if (isset($filter_range_key) && isset($_GET[$this->filter_range_keys[$filter_range_key][0]]) && isset($_GET[$this->filter_range_keys[$filter_range_key][1]])) {
			$min = (int) $_GET[$this->filter_range_keys[$filter_range_key][0]];
			$max = (int) $_GET[$this->filter_range_keys[$filter_range_key][1]];
			//unset($_GET[$this->filter_range_keys[$filter_range_key][0]]);
			//unset($_GET[$this->filter_range_keys[$filter_range_key][1]]);
			$new_list = array();
			foreach ($display_list as $car) {
				$v = $this->filter_range_relations[$filter_range_key];
				if ($car->$v >= $min && $car->$v <= $max)
					array_push($new_list, $car);
			}
			$display_list = $new_list;
		}
	}
}
?>

<div id="dn-inv-wrap">
<?php
if (count($display_list) == 0) {
?>
	<div>
		<p>No vehicles found<p>
		<p><a href="<?php echo home_url("/inventory/"); ?>">&laquo; Back to results</p>
	</div>
<?php
} else {
	$this->quick_sort($display_list, 'Model');
	$this->quick_sort($display_list, 'Make');
	// cars found
	//Kint::dump($this->car_list);
	echo '<style type="text/css" scoped>' . $list_css . '</style>';
	echo $this->parse_list_template($list_template, $display_list);
}
?>
</div>