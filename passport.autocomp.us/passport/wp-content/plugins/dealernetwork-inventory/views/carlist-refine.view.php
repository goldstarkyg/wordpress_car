<?php
if (!isset($type)) die('Missing type');
$title = ''; $prefix = '';
if (strpos($type, ' ')) {
	$split = explode(' ', $type, 2);
	$type = $split[0];
	preg_match_all('/ (.+?)="(.+?)"/', ' ' . $split[1], $params);
	for ($x = 0; $x < count($params[0]); $x++) {
		switch (strtolower($params[1][$x])) {
			case 'title':
				$title = $params[2][$x];
				break;
			case 'step':
				$step = (int) $params[2][$x];
				break;
			case 'max':
				$max = (int) $params[2][$x];
				break;
			case 'prefix':
				$prefix = $params[2][$x];
				break;
			case 'collapsed':
				if (strtolower($params[2][$x]) == 'true') {
					$collapsed = true;
				}
				break;
		}
	}
}
// regular filters
if (array_key_exists($type, $this->filter_keys) && array_key_exists($this->filter_keys[$type], $this->filter_relations)) {
	$items = array();
	$unique_items = array();
	$list = array();
	foreach ($car_list as $car) {
		$value = $this->filter_relations[$this->filter_keys[$type]];
		array_push($items, $car->$value);
		if (!in_array($car->$value, $unique_items))
			array_push($unique_items, $car->$value);
		unset($value);
	}
	asort($unique_items);
	foreach ($unique_items as $item) {
		array_push($list, array($item, $this->add_query_var($this->filter_keys[$type], $item), array_count_values($items)[$item]));
	}
// range filters
} else if (array_key_exists($type, $this->filter_range_keys) && array_key_exists($type, $this->filter_range_relations)) { 
	if (!isset($step)) {
		echo "$type missing step definition.";
		return;
	}
	if (!isset($max)) {
		echo "$type missing max definition.";
		return;
	}
	$items = array();
	$unique_items = array();
	$list = array();
	foreach ($car_list as $car) {
		for ($x = $step; $x < $max; $x += $step) {
			$value = $this->filter_range_relations[$type];
			if ($car->$value <= $x) {
				array_push($items, $x);
				if (!in_array($x, $unique_items))
					array_push($unique_items, $x);
				break;
			}
		}
	}
	asort($unique_items);
	foreach ($unique_items as $item) {
		$display_min = ($item - $step) == 0 ? 0 : $item - ($step - 1);
		$url = $this->add_query_var($this->filter_range_keys[$type][0], $display_min);
		$url = $this->add_query_var($this->filter_range_keys[$type][1], $item, $url);
		//array_push($list, array($prefix . number_format($display_min) . ' - ' . $prefix . number_format($item), $url, array_count_values($items)[$item]));
        array_push($list, array($prefix . number_format($item), $url, array_count_values($items)[$item]));
	}
}
?>

<div class="dn-inv-refine">
<?php if (!isset($list)) { echo $type;?>
	<p>Invalid request</p>
<?php } else { 
	echo "<h5 class=\"collapsible" . (isset($collapsed) && $collapsed ? " collapsed" : "") . "\">$title</h5>";
	echo '<div>';
	if (count($list) <= 5) {
		echo '<ul>';
		for ($x = 0; $x < count($list); $x++) {
			$name = $list[$x][0];
			$url = $list[$x][1];
			$count = $list[$x][2];
			echo "<li><a href=\"$url\">$name ($count)</a></li>";
		}
		echo '</ul>';
	} else {
		echo '<ul>';
		for ($x = 0; $x < 5; $x++) {
			$name = $list[$x][0];
			$url = $list[$x][1];
			$count = $list[$x][2];
			echo "<li><a href=\"$url\">$name ($count)</a></li>";
		}
		echo '</ul>';
		echo '<ul id="dn-inv-refine-' . strtolower($type) . '" style="display:none;">';
		for ($x = 5; $x < count($list); $x++) {
			$name = $list[$x][0];
			$url = $list[$x][1];
			$count = $list[$x][2];
			echo "<li><a href=\"$url\">$name ($count)</a></li>";
		}
		echo '</ul>';
		echo '<span class="dn-inv-refine-more">&raquo; View More</span>';
	}
	echo '</div>';
} ?>
</div>