<div class='inventory-filter'>
View by:
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

<div class='mobile-inventory-filter dropdown'>
	<button class="btn btn-default dropdown-toggle" style="margin-right: 0" type="button" data-toggle="dropdown">View By
		<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<?php
		$first = true;
		foreach ($this->rpp_values as $key=>$value) {
			$qs = $key;
			$a_title = "View by $value";
			$a_href = $this->add_query_var($this->rpp_key, $qs);
			if (intval($this->records_per_page) == intval($key)) {
				echo "<li class='drop-margin'><a title=\"$a_title\" href=\"$a_href\">$value</a></li>";
			} else {
				echo "<li class='drop-margin'><a title=\"$a_title\" href=\"$a_href\">$value</a></li>";
			}
		}
		?>
	</ul>
</div>
