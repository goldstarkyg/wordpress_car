<?php
function truncate($str, $limit) {
	if (strlen($str) <= $limit) return $str;
	return substr($str, 0, $limit - 3) . '...';
}
?>