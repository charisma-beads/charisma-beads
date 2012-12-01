<?php // final.php Tuesday, 3 May 2005
// This is the final page for the site.
// Checkout process 3/3.

// Set the page title and include the HTML header.	
$page_title = "Order Completed";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

if (isset($_GET['oid'])) {
	
	$query = "
			SELECT order_status, invoice, total
			FROM customer_orders, customer_order_status
			WHERE order_id={$_GET['oid']}
			AND customer_orders.order_status_id = customer_order_status.order_status_id
			";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
    $content .= '
	<h2>Thank you for your order. We will process and dispatch your order as soon as possible.</h2>
	<h3>Order No. '.$row['invoice'].'</h3>
	<p>Order Status: '.$row['order_status'].'</p>
	<p>Total Amount: '.$row['total'].'</p>
	';

} else {
	header('Location: '.$merchant_website);
}

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>
