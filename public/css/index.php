<?php /* Created on: 02/05/2006 */
	include_once ('rootpath.php');
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/merchant_data.php');
	header ("Location: $merchant_website");
?>