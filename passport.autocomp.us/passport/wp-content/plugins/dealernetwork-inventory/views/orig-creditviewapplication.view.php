<?php
	$width = $attributes != "" && array_key_exists("width", $attributes) ? $attributes['width'] : '100%';
	$height = $attributes != "" && array_key_exists("height", $attributes) ? $attributes['height'] : '800';
?>
<iframe src='http://external.dealernetwork.com/Credit/?LocationID=<?php echo $this->location->LocationID; ?>' width='<?php echo $width; ?> ' height='<?php echo $height; ?>' scrolling='yes' onload='window.parent.parent.scrollTo(0,0);'></iframe>