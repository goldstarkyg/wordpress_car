<?php
if (!isset($type)) die('Missing type');
$title = '';
$collapsed = true;
if (strpos($type, ' ')) {
	$split = explode(' ', $type, 2);
	$type = $split[0];
	preg_match_all('/ (.+?)="(.+?)"/', ' ' . $split[1], $params);
	for ($x = 0; $x < count($params[0]); $x++) {
		switch (strtolower($params[1][$x])) {
			case 'title':
				$title = $params[2][$x];
				break;
			case 'collapsed':
				$collapsed = strtolower($params[2][$x]) == 'true';
				break;
		}
	}
}
$path = dirname(__FILE__) . '/' . $type . '.form.php';
if (file_exists($path)) {
	$class = 'collapsible collapsed';
	if ((isset($_POST[$type . '_hidden']) && $_POST[$type . '_hidden'] == 'Y') || !$collapsed)
		$class = 'collapsible';
?>
	<div class="dn-car-forms">
		<h4 class="<?php echo $class; ?>"><?php echo $title; ?></h4>
		<div>
			<form method="post" action="<?php echo $this->current_url; ?>" class="validate-me">
				<input type="hidden" name="<?php echo $type; ?>_hidden" value="Y" />
				<input type="hidden" name="<?php echo $type; ?>_title" value="<?php echo $title; ?>" />
				<?php include($type . '.form.php'); ?>
			</form>
		</div>
	</div>
<?php } else { ?>
	Invalid type
<?php } ?>