<div id="dn-inv-search">
<?php
$val = isset($_GET[$this->filter_keys['search']]) ? $_GET[$this->filter_keys['search']] : '';
?>
<form method="get" id="inventorysearch" action="<?php echo home_url('/inventory/'); ?>">
	<label class="screen-reader-text" for="q">Search for:</label>
	<input type="text" name="q" id="q" value="<?php echo $val; ?>" />
	<?php foreach ($_GET as $key=>$value) { if ($key == $this->filter_keys['search']) continue; ?>
	<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" />
	<?php } ?>
	<input type="submit" value="Search" class="btn_default" />
</form>
</div>