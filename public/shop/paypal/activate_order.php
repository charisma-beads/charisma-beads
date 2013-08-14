<?php // final.php Tuesday, 3 May 2005
// This is the final page for the site.
// Checkout process 3/3.

// Set the page title and include the HTML header.	
$page_title = "Order Activation";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
/*
if ($_GET['oid']) {
	
	$query = "
		SELECT order_status_id
		FROM customer_order_status
		WHERE order_status = 'Waiting for Payment'
		LIMIT 1
	";
	$result = mysql_query ($query);
		
	$osid = mysql_result($result,0,'order_status_id');
	
	$query = "
			UPDATE customer_orders
			SET order_status_id = $osid
			WHERE order_id = {$_GET['oid']}
	";
	
	$result = mysql_query($query);
	
	if (mysql_affected_rows() == 1) {
		
        Utility::go("/shop/users/view_order.php?oid={$_GET['oid']}");
		
	} else {
		
		$query = "
				SELECT invoice
				FROM customer_orders
				WHERE order_id = {$_GET['oid']}
		";
	
		$result = mysql_query($query);
		
		$invoice = mysql_fetch_array($result);
		
		$content .= "<h3>Your order could not be reactivated due to a system error.</h3>";
		$content .= "<table><tr><td class=\"button\">Please email <a href=\"mailto:webmaster@charismabeads.co.uk?subject=$merchant_name - Reactivate Order #{$invoice[0]}\">Webmaster</a> to reactivate your order manually</td></tr></table>";
		
	}
	
}
*/
// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>