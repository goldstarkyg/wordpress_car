<div class="dn-inv-search">
	<?php
	$val = isset($_GET[$this->filter_keys['search']]) ? $_GET[$this->filter_keys['search']] : '';
	?>
	<form method="get" class="inventorysearch"  id="inventorysearch"  action="<?php echo $this->current_url; ?>">
		<label class="screen-reader-text" for="q">Search for make/model:</label>
		<input class="form-control dark_rounded"  placeholder="Search" type="text" name="q" id="q" value="<?php echo $val; ?>" />
		<?php foreach ($_GET as $key=>$value) { if ($key == $this->filter_keys['search']) continue; ?>
			<input type="hidden" class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" />
		<?php } ?>
		<input type="submit" class="form-control" value="SEARCH"  />
	</form>
</div>