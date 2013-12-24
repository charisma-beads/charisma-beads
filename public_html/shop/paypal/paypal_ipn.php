<?php
	
	/*  PHP Paypal IPN Integration Class Demonstration File
	*  4.16.2005 - Micah Carrick, email@micahcarrick.com
	*
	*  This file demonstrates the usage of paypal.class.php, a class designed  
	*  to aid in the interfacing between your website, paypal, and the instant
	*  payment notification (IPN) interface.  This single file serves as 4 
	*  virtual pages depending on the "action" varialble passed in the URL. It's
	*  the processing page which processes form data being submitted to paypal, it
	*  is the page paypal returns a user to upon success, it's the page paypal
	*  returns a user to upon canceling an order, and finally, it's the page that
	*  handles the IPN request from Paypal.
	*
	*  I tried to comment this file, aswell as the acutall class file, as well as
	*  I possibly could.  Please email me with questions, comments, and suggestions.
	*  See the header of paypal.class.php for additional resources and information.
	*/
	//ob_start();
	// Setup class
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
    
	$p = new Paypal(); // initiate an instance of the class
	
	$p->paypal_url = ($deploy == 'test') ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	
	// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
	$this_script = $https.'/shop/paypal/paypal_ipn.php';
	
	// if there is not action variable, set the default action of 'process'
	if (empty($_GET['action'])) $_GET['action'] = 'process';
	
	switch ($_GET['action']) {
		
	case 'process':
		
		$p->add_field('business', $pp_merchant_id);
		$p->add_field('cmd','_cart');
		$p->add_field('upload','1');
		$p->add_field('return', $this_script.'?action=success&oid='.$oid);
		$p->add_field('cancel_return', $this_script.'?action=cancel&oid='.$oid);
		$p->add_field('notify_url', $this_script.'?action=ipn&oid='.$oid);
		$p->add_field('image_url', $https.'/template/charisma.gif');
		$p->add_field('custom', $oid);
		$p->add_field('invoice', $invoice_no);
		$p->add_field('rm','2');           // Return method = POST
		
		$c = 1;
		foreach ($_SESSION['pp_cart'] as $item => $contents) {
				
			$p->add_field ('item_number_' . $c, $item);
					
			foreach ($contents as $name => $value) {
				$p->add_field($name . "_" . $c, $value);
			}
				
			$c++;
		}
		
		$p->add_field('shipping_1', $cartTotals['POST_COST']);
		$p->add_field('currency_code', $pp_currency);
		
		// prepopulate address details.
		$query = "
				SELECT first_name, last_name, address1, address2, address3, city, county, post_code, email, phone
				FROM customers, customer_orders
				WHERE order_id=$oid
				AND customers.customer_id=customer_orders.customer_id
				LIMIT 1";
		//print $query;
		$result = mysql_query($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		
		$p->add_field('first_name', $row[0]);
		$p->add_field('last_name', $row[1]);
		$p->add_field('address1', $row[2]);
		$p->add_field('address2', $row[3]);
		$p->add_field('address3', $row[4]);
		$p->add_field('city', $row[5]);
		$p->add_field('state', $row[6]);
		$p->add_field('zip', $row[7]);
		$p->add_field('country', 'GB');
		$p->add_field('email', $row[8]);
		$p->add_field('night_phone_a', '44');
		$p->add_field('night_phone_b', $row[9]);
		
		$content .= $p->submit_paypal_post(); // submit the fields to paypal
		//$p->dump_fields();      // for debugging, output a table of all the fields
		break;
		
	case 'success':
		
        Utility::go("paypal_return.php?oid=".$_GET['oid']);
		
		break;
		
	case 'cancel':       // Order was canceled...
	
		// The order was canceled before being completed.
	
		//echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
		//echo "</body></html>";
		
        Utility::go("cancel_order.php?oid=".$_GET['oid']);
		
		break;
		
	case 'ipn':
		
		if ($p->validate_ipn()) {
					
			$verified_check = array();
			
			if (isset($p->ipn_data['txn_type']) && $p->ipn_data['txn_type'] == 'cart' && !isset($p->ipn_data['for_auction'])) {
				
				// get order id if not set.
				if (isset($_GET['oid'])) {
					$query = "
							SELECT order_id
							FROM customer_orders
							WHERE order_id = {$_GET['oid']}
							";
					$result = mysql_query($query);
					$oid = mysql_result($result,0,'order_id');
					$verified_check['oid'] = "PASS";
				} else if (isset($p->ipn_data['invoice'])) {
					$query = "
							SELECT order_id
							FROM customer_orders
							WHERE invoice = {$p->ipn_data['invoice']}
					";
					$result = mysql_query($query);
					$oid = mysql_result($result,0,'order_id');
					$verified_check['oid'] = "PASS";
				} else {
					$oid = FALSE;
					$verified_check['oid'] = "FAIL";
				}
				
				// check payment status
				if ($p->ipn_data['payment_status'] == "Completed") {
					$vps = TRUE;
					$verified_check['payment_status'] = "PASS";
				} else {
					$vps = FALSE;
					$verified_check['payment_status'] = "FAIL";
				}
				
				// check txn id of cart.
				if ($p->ipn_data['txn_id'] && $oid) {
					// is it a duplicate.
					$query = "
							SELECT txn_id
							FROM customer_orders
							WHERE txn_id='{$p->ipn_data['txn_id']}'
							AND order_id != $oid
					";
					$result = mysql_query($query);
					$rows = mysql_num_rows($result);
					
					if ($rows == 0) {
						// is it already been set.
						$query = "
							SELECT txn_id
							FROM customer_orders
							WHERE order_id = $oid 
						";
						$result = mysql_query($query);
						$txnid = mysql_result($result,0,'txn_id');
						
						if ($txnid == NULL) { // if not set it
							$query = "
								UPDATE customer_orders
								SET txn_id='{$p->ipn_data['txn_id']}'
								WHERE order_id = $oid
							";
			
							$result = mysql_query($query);
							
							$vtxnid = TRUE;
							$verified_check['txn_id'] = "PASS";
						} else {
							$vtxnid = FALSE;
							$verified_check['txn_id'] = "FAIL";
						}
						
					} else {
						$vtxnid = FALSE;
						$verified_check['txn_id'] = "FAIL";
					}
				} else {
					$vtxnid = FALSE;
					$verified_check['txn_id'] = "FAIL";
				}
				
				// check merchant email
				if ($p->ipn_data['receiver_email'] == $pp_merchant_id) {
					$vre = TRUE;
					$verified_check['receiver_email'] = "PASS";
				} else {
					$vre = FALSE;
					$verified_check['receiver_email'] = "FAIL";
				}
				
				// check merchant currency code
				if (substr($p->ipn_data['mc_currency'],0,3) == $pp_currency) {
					$vmcc = TRUE;
					$verified_check['mc_currency'] = "PASS";
				} else {
					$vmcc = FALSE;
					$verified_check['mc_currency'] = "FAIL";
				}
				
				// check total of shopping cart,
				if ($p->ipn_data['mc_gross'] && $oid) {
					$query = "
							SELECT total
							FROM customer_orders
							WHERE order_id = $oid
							";
					$result = mysql_query($query);
					$total = mysql_result($result,0,'total');
		
					if ($p->ipn_data['mc_gross'] == $total) {
						$vmcg = TRUE;
						$verified_check['mc_gross'] = "PASS";
					} else {
						$vmcg = FALSE;
						$verified_check['mc_gross'] = "FAIL";
					}
				} else {
					$vmcg = FALSE;
					$verified_check['mc_gross'] = "FAIL";
				}
				
				// if all is well update the payment status.
				if ($oid && $vps && $vtxnid && $vre && $vmcc && $vmcg) {
					$query = "
						SELECT order_status_id
						FROM customer_order_status
						WHERE order_status = 'Paypal Payment Completed'
						LIMIT 1
						";
					$result = mysql_query ($query);
			
					$osid = mysql_result($result,0,'order_status_id');
			
					$query = "
						UPDATE customer_orders
						SET order_status_id = $osid
						WHERE order_id = $oid
						";
			
					$result = mysql_query($query);
				}
				
				// For this example, we'll just email ourselves ALL the data.
		        $subject = 'Instant Payment Notification - Recieved Payment';
		        $to = "webmaster@charismabeads.co.uk";    //  your email
		        $body =  "An instant payment notification was successfully recieved\n";
		        $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
		        $body .= " at ".date('g:i A')."\n\nDetails:\n";

		        foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
		        $body .= "\n$query";

		        foreach ($verified_check as $key => $value) {
		            $body .= "\n$key: $value";
		        }

		        mail($to, $subject, $body);
			}
		}
		break;
	}
	//ob_end_flush();
?>
