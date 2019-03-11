<?php

//build a list of similar inventory by price
//TODO: pass filter types through the short code. so the similar inventory can be decided by other things than price. also, pass other parameters via shortcode.

$sortBy = 'price'; // mileage / make / year / fueltype / etc
$similarCars = array();
$sortKey;

//get current vehicle's data
if($sortBy == 'price') $sortKey = $car->Price;
if($sortBy == 'make') $sortKey = $car->Make;
if($sortBy == 'year') $sortKey = $car->Year;


//populate $similarCars
foreach ($this->car_list as $vehicle)
{
	//year
	$year_range = 5;
	if ($sortBy == "year")
	{
	    if ($vehicle->$Year <= ($sortKey + $year_range) && $vehicle->$Year >= ($sortKey - $year_range)) {
		   array_push($similarCars, $vehicle);
		}
	}

	//make
	if ($sortBy == "make")
	{
	    if ($vehicle->$Make == [car-make]) {
		    array_push($similarCars, $vehicle);
		}
	}
	
	//price
	$price_range = 5000;
	if ($sortBy == "price")
	{
	    if ($vehicle->Price >= ($sortKey - $price_range)  &&  $vehicle->Price <= ($sortKey + $price_range)) {
		    if($car != $vehicle) array_push($similarCars, $vehicle);
		}
	}
}

//fill inventoryToDisplay with "numberToDisplay" random vehicles

$numberToDisplay = 3;
$inventoryToDisplay = [];

if($numberToDisplay < count($similarCars))
{
	while(count($inventoryToDisplay) < $numberToDisplay)
	{
		$i = rand(0, count($similarCars)-1);
		if(!in_array($similarCars[$i], $inventoryToDisplay)) array_push($inventoryToDisplay, $similarCars[$i]);
	}
}else
{
	foreach($similarCars as $car)
	{
		array_push($inventoryToDisplay, $car);
	}
}
	
	
//display $inventoryToDisplay
if(count($inventoryToDisplay))
{
	foreach($inventoryToDisplay as $car)
	{
		$detailURL = $this->generate_detail_url($car);
		?>	
		
		<div>
		<a href="<?php echo $detailURL;?>" title="<?php echo $car->Year.' '.$car->Make.' '.$car->Model;?>"><img border="0" src="<?php echo $car->ImageUrls[0];?>"></a>
		<ul>
		  <li><a href="<?php echo $detailURL;?>"><?php echo $car->Year.' '.$car->Make.' '.$car->Model;?></a></li>
		  
		</ul>
		<div class="clear"></div>
		  </div>
		<?php 
	}
}else
{
	echo 'There are no similar vehicles to display';	
}
?>