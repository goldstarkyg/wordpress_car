<div>View by: 
<?php
	$first = true;
	foreach ($this->rpp_values as $key=>$value) {
		$qs = $key;
		if (!$first) echo '|';
		$first = false;
		
		$a_title = "View by $value";
		$a_href = $this->add_query_var($this->rpp_key, $qs);
		if (intval($this->records_per_page) == intval($key)) {
			echo $value;
		} else {
			echo "<a title=\"$a_title\" href=\"$a_href\">$value</a>";
		}
	}
?>
</div>