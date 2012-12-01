<?php 

// Set the page title and include the HTML header.	
$page_title = "Newsletter Unsubscribe";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

if ($_GET['email']) {
	
	$query = "
		SELECT customer_id, newsletter_id
		FROM customers
		WHERE email = '{$_GET['email']}'
	";
	
	$result = mysql_query($query);
	$row = mysql_fetch_array ($result, MYSQL_NUM);
	
	$query = "
		DELETE FROM newsletter
		WHERE newsletter_id = {$row[1]}
	";
	
	$result = mysql_query($query);
	
	if (mysql_affected_rows() == 1) {
		
		$query = "
			UPDATE customers
			SET newsletter_id=0
			WHERE customer_id=".$row[0]."
		";
		$result = mysql_query($query);
		
		$content .= '
		<p>You email address has been removed from the database</p>
		';
	} else {
		$content .= "<h3>Your email could not be deleted due to a system error.</h3>";
		$content .= "<table><tr><td class=\"button\">Please email <a href=\"mailto:$merchant_email?subject=$merchant_name - Unsubscribe #{$_GET['email']}\">$merchant_email</a> to cancel your subscription manually</td></tr></table>";
	}
}

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>
