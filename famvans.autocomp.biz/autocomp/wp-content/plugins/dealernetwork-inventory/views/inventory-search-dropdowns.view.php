<div id="dn-inv-search">
<?php
$years = array();
$makes = array();
$models = array();

foreach ($this->car_list as $car) {
	if (!in_array($car->Year, $years))
		array_push($years, $car->Year);
	if (!in_array($car->Make, $makes))
		array_push($makes, $car->Make);
	if (!in_array($car->Model, $models))
		array_push($models, $car->Model);
}
sort($years);
sort($makes);
sort($models);
?>
<style type="text/css" scoped>
.chosen-container, .chosen-single { width:170px !important; height:32px !important; }
.chosen-single span { margin-top: 5px; }
</style>
<form method="get" id="inventorysearch" action="<?php echo home_url('/inventory/'); ?>">
	<div class="row">
	<label class="screen-reader-text" for="<?php echo $this->filter_keys["year"]; ?>">Year:</label>
	<select data-placeholder="Select Year..." name="<?php echo $this->filter_keys["year"]; ?>" class="chosen">
		<option value=""></option>
		<?php foreach ($years as $year) { ?>
		<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="row">
	<label class="screen-reader-text" for="<?php echo $this->filter_keys["make"]; ?>">Make:</label>
	<select data-placeholder="Select a make..." name="<?php echo $this->filter_keys["make"]; ?>" class="chosen">
		<option value=""></option>
		<?php foreach ($makes as $make) { ?>
		<option value="<?php echo $make; ?>"><?php echo $make; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="row">
	<label class="screen-reader-text" for="<?php echo $this->filter_keys["model"]; ?>">Model:</label>
	<select data-placeholder="Select a model..." name="<?php echo $this->filter_keys["model"]; ?>" class="chosen">
		<option value=""></option>
		<?php foreach ($models as $model) { ?>
		<option value="<?php echo $model; ?>"><?php echo $model; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="row">
	<a href="<?php echo home_url('/inventory/'); ?>">View All</a>
	<span class="btn btn_search" style="opacity: 0.8;"><input type="submit" value="SEARCH"></span>
	<input type="reset" value="RESET SEARCH">
	</div>
</form>
</div>