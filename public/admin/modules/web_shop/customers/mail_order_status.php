<?php

if ($authorized) {

	$query = "
		SELECT CONCAT(prefix, ' ', first_name, ' ', last_name ) AS name, email, invoice, order_status, DATE_FORMAT(order_date, '%D %M %Y') AS date, order_id, customers.customer_id
		FROM customers, customer_prefix, customer_orders, customer_order_status
		WHERE customer_orders.order_id = {$_POST['oid']}
		AND customer_orders.order_status_id = customer_order_status.order_status_id
		AND customers.customer_id = customer_orders.customer_id
		AND customers.prefix_id = customer_prefix.prefix_id
		Limit 1
	";

	$result = mysql_query ($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	require_once ($_SERVER['DOCUMENT_ROOT'].'/../data/mail_options.php');
	
	// turn off strict errors for Pear
	
	/* we use the db_options and mail_options here */
	$mail_queue = new Mail_Queue($db_options, $mail_options);

	$from = $merchant_email;
	$to = $row['email'];

	$hdrs = array (
		'From'    => $from,
		'Subject' => $merchant_name . " Order {$row['invoice']} Status" . date('F Y'),
		'To' => $to
	);

	$message = "
		Dear {$row['name']}, \r\n\r\n
		Your order No. {$row['invoice']} \r\n\r\n
		Your order status is: {$row['order_status']} \r\n\r\n
		Kind Regards \r\n\r\n
		Charisma Beads Orders Department.
	";

	$mime = new Mail_mime();
	$mime->setTXTBody($message);
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);

	/* Put message to queue */
	$done = $mail_queue->put($from, $to, $hdrs, $body);

} else {
	header ("Location: http://www.charismabeads.co.uk");
	ob_end_clean();
	exit();
}
?>
