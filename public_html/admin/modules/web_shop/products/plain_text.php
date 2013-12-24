<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/mysql_connect.php");
$session = new Session(60*60*24);
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/authentication.php");

// Print a message based on authentication.
if (!$authorized) {
	
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
	
} else {
	if ($_POST['txt']) {
		$txt = html_entity_decode(strip_tags($_POST['txt']),ENT_QUOTES, 'UTF-8');
		echo $txt;
	}
}
?>
