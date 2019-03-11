<?php
if ($this->car_list != null) {

$carouselCarsToDisplay = [];
$year = array();
$make = array();
$model = array();
$carouselCarsToDisplayCount;


//build list of displayable cars

foreach($this->car_list as $car)
{
    if ($car->ImageUrls[0])
	{
		$year[] = $car->Year;
		$make[] = $car->Make;
		$model[] = $car->Model;
		$carouselCarsToDisplay[] = $car;
		
	}
}
shuffle($carouselCarsToDisplay);
$carouselCarsToDisplayCount = count($carouselCarsToDisplay);

}
?>

    <div id="owl-demo" class="owl-carousel owl-theme mini-multi" >
        <?php
		
        for($i = 0; $i < $carouselCarsToDisplayCount; $i++)
        {
            ?>
            <div class="item" >
                          
                        <a href='<?php echo $this->generate_detail_url($carouselCarsToDisplay[$i]); ?>' ><img src='<?php echo $carouselCarsToDisplay[$i]->ImageUrls[0]; ?>' /></a>
                        <div class="ymcarsoal-style"><?php echo $carouselCarsToDisplay[$i]->Year;?> <br/> <?php echo $carouselCarsToDisplay[$i]->Make;?></div>
                        <div class="pricecarsoal-style" style="font-size:15px; text-align:center; font-weight: bolder; padding:0;*line-height: 0;"> $<?php  echo $carouselCarsToDisplay[$i]->Price; ?></div> 
                  
            </div>
            <?php
        }
        ?>
            
    </div>
 
  