<ul>
<?php
	// generate sitemap
	foreach (get_pages(array()) as $page) {
		?>
		<?php if (strpos($page->post_content, '[dealernetwork-sitemap]') !== false) continue; ?>
		<li><a href="<?php echo get_permalink($page->ID); ?>"><?php echo $page->post_title; ?></a>
		<?php if (strpos($page->post_content, '[dealernetwork-inventory]') !== false) { ?>
			<ul>
				<?php foreach ($this->car_list as $car) { ?>
					<li><a href="<?php echo $this->generate_detail_url($car); ?>"><?php echo $car->Year . ' ' . $car->Make . ' ' . $car->Model . ' ' . $car->Trim; ?></li>
				<?php } ?>
			</ul>
		<?php } ?>
		</li>
		<?php
	}
	/*foreach ($this->car_list as $car) {
		$node = $xml->addChild('sitemap');
		$node->addChild('loc', $this->generate_detail_url($car));
		$node->addChild('lastmod', date('Y-m-d', $car->UpdatedOn));
	}*/
?>

</ul>