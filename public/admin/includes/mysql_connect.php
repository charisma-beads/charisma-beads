<?php // mysql_connect.php

// This file contains the database access information. It also establishes a connection to MySQL and selects the database.

// Set the database access information as constants.
define ('DB_USER', $merchant_db_user);
define ('DB_PASSWORD', $merchant_db_password);
define ('DB_HOST', $merchant_db_host);
define ('DB_NAME', $merchant_db_name);

/* @global $dbc */
$dbc = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

$errorLog = ErrorLogging::getInstance();

if ($dbc) { // Make the conection.

	if (!mysql_select_db (DB_NAME)) { // If it can't select the database.
	
		// Hadle the error.
		 $errorLog->sqlErrorHandler(mysql_errno(), 'Could not select the database: ' . mysql_error(), '');
		
		// Print the message to the user, include the footer, and kill the script.
		print "<span class=\"smcaps\"><p class=\"fail\"> <img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" /> This site is currently experiencing technical difficulties. We apologize for any inconvenience.</p></span>";
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/html_bottom');
		exit();

	} // End of mysql_select_db IF.

} else { // If it could't connect to MySQL.

	// Print message to user, include the footer, and kill the script.
	$errorLog->sqlErrorHandler(mysql_errno(), 'Could not connect to the database: ' . mysql_error(), '');
	print "<span class=\"smcaps\"><p class=\"fail\"> <img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" /> This site is currently experiencing technical difficulties. We apologize for any inconvenience.</p></span>";
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/html_bottom');
	exit();
	
} // End of dbc IF.

mysql_set_charset('utf8', $dbc);

// Function for escaping and trimming form data.
function escape_data ($data) {
	global $dbc;
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	return mysql_real_escape_string (trim ($data), $dbc);
} // End of escape_data function.
?>