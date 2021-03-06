<?php

if ($this->car_list != null) {
	if ($this->mobile_detect->isMobile()) {
	
		//---------------------------------------------
		// variables for website design

		$slideshowHeight = 200; //px
		$slideshowWidth = 335; //px

		//---------------------------------------------
		
		if ($this->mobile_detect->isTablet()) {
			//---------------------------------------------
			// variables for website design
			$slideshowHeight = 300; //px
			$slideshowWidth = 465; //px
			//---------------------------------------------
		}
		
	} 
	
	else {
		$template = $this->settings['CarouselTemplate'];
		$css = $this->settings['CarouselTemplateCSS'];
		//---------------------------------------------
		// variables for website design

		$slideshowHeight = 500; //px
		$slideshowWidth = 665; //px

		//---------------------------------------------
	}

$carsToDisplay = [];
$slideText1 = [];
$slideText2 = [];

foreach($this->car_list as $car)
{
    if ($car->ImageUrls[0]) $carsToDisplay[] = $car;
}
shuffle($carsToDisplay);
}
?>

<div id="imgContainer" style=" height:<?php echo $slideshowHeight; ?>px; width:<?php echo $slideshowWidth; ?>px; overflow: hidden; position: relative;">
        <?php
        foreach($carsToDisplay as $key => $car)
        {
            echo '<a href="'.$this->generate_detail_url($car).'"><img src="'.$car->ImageUrls[0].'" id="slideImg'.$key.'" style="width: 100%; float: left; position: absolute;" /></a>';
            $slideText1[$key] = $car->Year.' '.$car->Make.' '.$car->Model.' '.$car->Trim;
            $slideText2[$key] = $car->Price;
        }
        ?>
    
        <div style=" opacity: 0.75; position: absolute; bottom: 0; left: 0; background: #000000; color: #ffffff; width: 100%; z-index: <?php count($carsToDisplay)+1 ?>;">
            <p style="display: block;"></p><div style="font-size:12px; float:right; color:#9c9c9c;"><b><b><b><b><div id='slideCaption1'><span><?php echo $carsToDisplay[0]->Year.' '.$carsToDisplay[0]->Make.' '.$carsToDisplay[0]->Model.' '.$carsToDisplay[0]->Trim ?></span></div></b></b></b></b></div><b><b><b><br><div style="float:right; font-size:20px; color:#9C9C9C!important;"><div id='slideCaption2'><span><?php echo '$'.$carsToDisplay[0]->Price ?></span></div></div></b></b></b><p></p></div></div>


<script>
    
    for(var i = 1; i < <?php echo count($carsToDisplay) ?>; i++)
    {
        jQuery('#slideImg'+i).css('display', 'none');
    }
    
    var count = <?php echo json_encode(count($carsToDisplay)); ?>;
    var i = 0;
    var slideText1 = <?php echo json_encode($slideText1); ?>;
    var slideText2 = <?php echo json_encode($slideText2); ?>;
    setInterval(function()      
    {
      jQuery('#slideImg'+i).fadeOut("slow");
      i = (i+1)%count;
      jQuery('#slideImg'+i).fadeIn("slow");
      jQuery('#slideCaption1 span').fadeOut();
      jQuery('#slideCaption2 span').fadeOut(function()
      {
        jQuery('#slideCaption1 span').text(slideText1[i]);
        jQuery('#slideCaption1 span').fadeIn();
        jQuery('#slideCaption2 span').text('$'+slideText2[i]);
        jQuery('#slideCaption2 span').fadeIn();
      });
    }, 4000);
    
</script>