<?php /* Created on: 02/05/2006 */
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/merchant_data.php');
	if ($_SERVER['HTTPS'] == "on") {
		$url = $https;
	} else {
		$url = $merchant_website;
	}
	header ("Location: $url/");
	exit();
?>