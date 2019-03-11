<form id="frame-dropdown" method='get' action='/inventory/'>
<select id="year" name='yr'>
<option value="" style="display:none;" selected>Any Year</option>
<option value="">---</option>
</select>
<select id="make" name='mk' placeholder="Select Make">
<option value="" style="display:none;" selected>Any Make</option>
<option value="">---</option>
</select>
<select id="model" name='md' placeholder="Select a model">
<option value="" style="display:none;" selected>Any Model</option>
<option value="">---</option>
</select><br/>
<div align="center">
<input value="Search Cars Now" type="submit" class="custbtntop" />
</div>
</form>
<script>

jQuery("#frame-dropdown").on("reset", function() {
    setTimeout(function() {
        console.log("reset");
        jQuery("#year").trigger("change");
        jQuery("#make").trigger("change");
        jQuery("#model").trigger("change");
    }, 1);
});

</script>
<script>
//all cars that fit all three dropdowns
var filteredCars = [];
var carList = [];
var yearSelected;
var makeSelected;
var modelSelected;

	carList = <?php echo json_encode($this->car_list); ?>;
	populateDropdowns();

//on change, build a list of cars filtered by what is chosen in all three boxes
jQuery('#year').change(function() {populateFilteredCars();});
jQuery('#make').change(function() {populateFilteredCars();});
jQuery('#model').change(function() {populateFilteredCars();});

function populateFilteredCars()
{
	filteredCars.length = 0;
	jQuery(this).change(function()
	{
		yearSelected = jQuery('#year').val();
		makeSelected = jQuery('#make').val();
		modelSelected = jQuery('#model').val();
		
		jQuery.each(carList, function()
		{
			if  ((yearSelected == "" || yearSelected == this.Year) && (makeSelected == "" || makeSelected == this.Make) && (modelSelected == "" || modelSelected == this.Model))
			{
				filteredCars.push(this);
			}
		});
		populateDropdowns();
	});
}

function populateDropdowns()
{

	var yearsToDisplay = [];
	var makesToDisplay = [];
	var modelsToDisplay = [];
	
	if(filteredCars.length) //an option has been selected
	{	
         //clear the current lists	
		jQuery('#year').children('option:gt(1)').remove();
		jQuery('#make').children('option:gt(1)').remove();
		jQuery('#model').children('option:gt(1)').remove();
			
         //populate *ToDisplay lists from filteredCars
		
		jQuery.each(filteredCars, function()
		{
			if(jQuery.inArray(this.Year, yearsToDisplay) < 0) yearsToDisplay.push(this.Year);
			if(jQuery.inArray(this.Make, makesToDisplay) < 0) makesToDisplay.push(this.Make);
			if(jQuery.inArray(this.Model, modelsToDisplay) < 0) modelsToDisplay.push(this.Model);
		});
                
        //sort lists
                yearsToDisplay.sort(function(a, b){return a-b;});
                yearsToDisplay.reverse(function(a, b){return a-b;});
                makesToDisplay.sort();
                modelsToDisplay.sort();
                
	}else //no options have been selected (initial state)
	{
         //clear the current lists
			jQuery('#year').children('option:gt(1)').remove();
			jQuery('#make').children('option:gt(1)').remove();
			jQuery('#model').children('option:gt(1)').remove();
		
		jQuery.each(carList, function()
		{
			if(jQuery.inArray(this.Year, yearsToDisplay) < 0) yearsToDisplay.push(this.Year);
			if(jQuery.inArray(this.Make, makesToDisplay) < 0) makesToDisplay.push(this.Make);
			if(jQuery.inArray(this.Model, modelsToDisplay) < 0) modelsToDisplay.push(this.Model);
		});
        //sort lists
                yearsToDisplay.sort(function(a, b){return a-b;});
                yearsToDisplay.reverse(function(a, b){return a-b;});
                makesToDisplay.sort();
                modelsToDisplay.sort();
	}
	
	//populate <select>s
	
		//#year
		jQuery.each(yearsToDisplay, function()
		{
			jQuery('#year').append('<option value="' + this + '">' + this + '</option>');
			//jQuery( "#year").prepend('<option value="' + this + '">' + this + '</option>');
			
		});
		
		//#make
		jQuery.each(makesToDisplay, function()
		{
			jQuery('#make').append('<option value="' + this + '">' + this + '</option>');
		});
		
		//#model
		jQuery.each(modelsToDisplay, function()
		{
			jQuery('#model').append('<option value="' + this + '">' + this + '</option>');
		});
		
	//assign selected values
		jQuery('#year').val(yearSelected);
		jQuery('#make').val(makeSelected);
		jQuery('#model').val(modelSelected);
		
};
</script>