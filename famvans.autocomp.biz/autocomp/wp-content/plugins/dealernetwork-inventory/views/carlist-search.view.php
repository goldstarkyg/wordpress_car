<div id="dn-inv-search">
<?php
$val = isset($_GET[$this->filter_keys['search']]) ? $_GET[$this->filter_keys['search']] : '';
?>
<form method="get" id="inventorysearch" action="<?php echo $this->current_url; ?>">
	<label class="screen-reader-text" for="q">Search for make/model:</label>
	<input type="text" name="q" id="q" value="<?php echo $val; ?>" />
	<?php foreach ($_GET as $key=>$value) { if ($key == $this->filter_keys['search']) continue; ?>
	<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" />
	<?php } ?>
	<span class="btn btn_search" style="opacity: 0.8;"><input type="submit" value="SEARCH"></span>
</form>
</div>