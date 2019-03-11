<?php
$count = 0;
$bald_url = $this->current_url;
foreach ($_GET as $key=>$value) {
	if (in_array($key, $this->filter_keys) && $value != "") { // regular filters
		$count++;
		?>
		<div class="dn-inv-filter">
			<?php echo $this->filter_values[$key]; ?>:&nbsp;
			<div class="tag"><span><?php echo $this->truncate($value, 20); ?>&nbsp;&nbsp;</span><a href="<?php echo $this->remove_query_var($key); ?>" title="Remove">x</a></div>
			<div class="tags_clear"></div>
		</div>
		<?php
	} else { // range filters	
		foreach ($this->filter_range_keys as $ak=>$av) {
			if (in_array($key, $av)) {
				$filter_range_key = $ak;
			}
		}
		if (isset($filter_range_key) && isset($_GET[$this->filter_range_keys[$filter_range_key][0]]) && isset($_GET[$this->filter_range_keys[$filter_range_key][1]])) {
			$min = (int) $_GET[$this->filter_range_keys[$filter_range_key][0]];
			$max = (int) $_GET[$this->filter_range_keys[$filter_range_key][1]];
			$suffix = (strpos($filter_range_key, 'price') !== false) ? '$' : '';
			$display = $suffix . number_format($min) . ' - ' . $suffix . number_format($max);
			$url = $this->remove_query_var($this->filter_range_keys[$filter_range_key][0]);
			$url = $this->remove_query_var($this->filter_range_keys[$filter_range_key][1], $url);
			unset($_GET[$this->filter_range_keys[$filter_range_key][0]]);
			unset($_GET[$this->filter_range_keys[$filter_range_key][1]]);
			?>
			<div class="dn-inv-filter">
				<?php echo $this->filter_range_values[$filter_range_key]; ?>:&nbsp;
				<div class="tag"><span><?php echo $this->truncate($display, 20); ?>&nbsp;&nbsp;</span><a href="<?php echo $url; ?>" title="Remove">x</a></div>
				<div class="tags_clear"></div>
			</div>
			<?php
		}
	}
	$bald_url = $this->remove_query_var($key, $bald_url);
}
if ($count > 0) { ?>
	<div class="dn-inv-filter">
		<a href="<?php echo $bald_url; ?>"></a>
	</div>
<?php } ?>