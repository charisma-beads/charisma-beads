<?php // final.php Tuesday, 3 May 2005
// This is the final page for the site.
// Checkout process 3/3.

// Set the page title and include the HTML header.	
$page_title = "Order Cancelled";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

if ($_GET['oid']) {
	
	$query = "
		SELECT order_status, order_id, invoice, total, cart
		FROM customer_orders, customer_order_status
		WHERE  customer_orders.order_status_id=customer_order_status.order_status_id
		AND customer_orders.order_id={$_GET['oid']}
	";
	$result = mysql_query($query);
	
	$order_status = mysql_result($result,0,'order_status');
	
	$order_id = mysql_result($result,0,'order_id');
	$invoice = mysql_result($result,0,'invoice');
	$total = mysql_result($result,0,'total');
    $cart = unserialize(mysql_result($result, 0, 'cart'));

	
	if ($order_status == "Paypal Payment Completed") {
        Utility::go("paypal_return.php?oid={$_GET['oid']}");
	} else {
	
		$query = "
			SELECT order_status_id
			FROM customer_order_status
			WHERE order_status = 'Cancelled'
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

             foreach ($cart as $key => $value) {
                $query = "
                    SELECT hits, quantity
                    FROM products
                    WHERE product_id = $key
                ";

                $result = mysql_query($query);
                $hits = mysql_result($result,0,'hits');
                $qty = mysql_result($result,0,'quantity');

                if ($qty > -1) {
                    mysql_query("
                        UPDATE products
                        SET quantity = $qty + {$value['Qty']}
                        WHERE product_id = $key
                    ");
                }

                mysql_query("
                    UPDATE products
                    SET hits = $hits - {$value['Qty']}
                    WHERE product_id = $key
                ");
             }

			$content .= "<h3>Your order is cancelled.</h3>";
		
			$content .= '
			<p>Please make a note of the cancelled order for your records</p>
			<p>Order ID: '.$order_id.'</p>
			<p>Invoice Number: '.$invoice.'</p>
			<p>Total: '.$total.'</p>
			';

            //$content .= '
            //<p>If this cancellation is a mistake please click button below to reactivate your order.</p>
            //<table><tr><td class="button"><a href="/shop/paypal/activate_order.php?oid='.$_GET['oid'].'">Reactivate Order</a></td></tr></table>
            //';
				
			// email merchant that order was cancelled
			
			$sendMail = new SendMail($sendMailconfig);
				
			$mailData = array(
				'to' => $sendMailconfig['address_list']['orders'],
				'from' => $sendMailconfig['address_list']['default'],
				'subject' => 'Web Order - Cancelled Order',
				'body' => "invoice number $invoice was cancelled\n",
			);
				
			$sendMail->sendEmail($mailData);
		
		} else {
				
			$query = "
				SELECT invoice
				FROM customer_orders
				WHERE order_id = {$_GET['oid']}
			";
	
			$result = mysql_query($query);
		
			$invoice = mysql_fetch_array($result);
				
			$content .= "<h3>Your order could not be cancelled due to a system error.</h3>";
			$content .= "<table><tr><td class=\"button\">Please email <a href=\"mailto:$merchant_email?subject=$merchant_name - Cancel Order #{$invoice[0]}\">$merchant_email</a> to cancel your order manually</td></tr></table>";
		}
	}
	
}

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>