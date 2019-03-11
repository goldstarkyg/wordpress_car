<div class='inventory-filter'>Sort by:
<?php
	$first = true;
	foreach ($this->sort_values as $key=>$value) {
		$qs = $key;
		$qs .= ($this->sort_descending && $key == $this->sort_by) ? 'asc' : 'desc';
		if (!$first) echo '|';
		$first = false;
		$a_title = "Sort by $value";
		$a_href = $this->add_query_var($this->sort_key, $qs);
		if ($key == $this->sort_by) {
			$class = ($this->sort_descending) ? 'dn-inv-sort desc' : 'dn-inv-sort asc';
			echo "<a title=\"$a_title\" href=\"$a_href\" class=\"$class\">$value</a>";
		} else {
			echo "<a title=\"$a_title\" href=\"$a_href\">$value</a>";
		}
	}
?>
</div>

<div class='mobile-inventory-filter dropdown'>
	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Sort By
		<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<?php
		$first = true;
		foreach ($this->sort_values as $key=>$value) {
			$qs = $key;
			$qs .= ($this->sort_descending && $key == $this->sort_by) ? 'asc' : 'desc';
			$a_title = "Sort by $value";
			$a_href = $this->add_query_var($this->sort_key, $qs);
			if ($key == $this->sort_by) {
				$class = ($this->sort_descending) ? 'dn-inv-sort desc' : 'dn-inv-sort asc';
				echo "<li class='drop-margin' ><a title=\"$a_title\" href=\"$a_href\" >$value</a> </li>";
			} else {
				echo "<li class='drop-margin' ><a title=\"$a_title\" href=\"$a_href\">$value</a> </li>";
			}
		}
		?>
	</ul>
</div>


