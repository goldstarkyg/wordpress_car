<?php
if ($this->car_list != null) {
	if ($this->mobile_detect->isMobile()) {
		$template = $this->settings['FeaturedTemplateMobile'];
		$css = $this->settings['FeaturedTemplateCSSMobile'];
	} else {
		$template = $this->settings['FeaturedTemplate'];
		$css = $this->settings['FeaturedTemplateCSS'];
	}
?>
<div class="dn-inv-wrap">
<?php
	$featured_list = array();
	foreach($this->car_list as $car) {
		if ($car->Featured)
			array_push($featured_list, $car);
	}
	
	$max = 5;
	if ($attributes != "" && array_key_exists("count", $attributes) && is_numeric($attributes["count"])) {
		$max = intval($attributes["count"]);
	}
	if ($max > count($featured_list))
		$max = count($featured_list);
		
	if (count($featured_list) == 0) {
		?>
		<p>No Featured Vehicles</p>
		<?php
	} else {
		if ($template != null) {
			echo '<style type="text/css" scoped>' . $css . '</style>';
			echo $this->parse_list_template($template, $featured_list, array ('[featuredlist-count]' => count($featured_list)));
		}
	}
?>
</div>
<?php } ?>