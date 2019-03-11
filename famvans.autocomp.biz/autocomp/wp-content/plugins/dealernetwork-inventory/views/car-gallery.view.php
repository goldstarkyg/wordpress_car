<?php if (count($car->ImageUrls) > 0) { ?>
<div class="gallery">
	<div id="gallery">
		<div>
			<div id="loading"></div>
			<div id="slideshow"></div>
		</div>
		<div id="controls"></div>
	</div>
	<div id="thumbs">
		<ul class="thumbs noscript">
		<?php foreach ($car->ImageUrls as $image_url) { ?><li style="list-style:none;"><a class="thumb" name="optionalCustomIdentifier" href="<?php echo $image_url; ?>" title="<?php echo $car->Year . ' ' . $car->Make . ' ' . $car->Model; ?>"><img src="<?php echo $image_url; ?>" alt="<?php echo $car->Year . ' ' . $car->Make . ' ' . $car->Model; ?>" /></a></li><?php } ?>
			<div style="clear:both;"></div>
		</ul>
	</div>
</div>
<?php } ?>