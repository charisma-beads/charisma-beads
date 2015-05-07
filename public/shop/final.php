<?php // final.php Tuesday, 3 May 2005
// This is the final page for thereceived/ Checkout process 3/3.

// Set the page title and include the HTML header.
$page_title = "Checkout";
// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

if (isset($_SESSION['cid']) && $_GET['stage'] == 2 && $cart->getNumCartItems() != 0) {

    /* @var $cart MiniCart */
	$error = FALSE;

    $invoice = new Invoice($dbc);
    
    if ($_SESSION['collect_instore'] === true) $cart->setCollectInstore();

	$content .= "<h1>Payment: Step 3 of 3</h1>";
	# *** This page will receive the approval code. *** #
	//$approved = 'Y'; // Practice

	// Turn the cart into a database-safe version.
	//$c = addslashes (serialize ($_SESSION['cart']));
    /*
     * $_SESSION['cart'][$_GET['pid']] =
     * array (
     *      'Qty' => $qty,
     *      'Price' => $row['price'],
     *      'vat' => number_format($tax,2)
     * );
     */

    $i = $invoice->displayInvoice($_SESSION['cid'], $cart);
    $cartItems = $invoice->fixPrices($cart);
    $cartTotals = $cart->getCartTotals(true);
    $cartTotals['CART_TOTAL'] = str_replace(',', '', $cartTotals['CART_TOTAL']);

    $c = addslashes (serialize ($cartItems));

	// Find the last invoice No.
	$query = "
		SELECT MAX(invoice)
		FROM customer_orders";
	$result = mysql_query ($query);

	if ($num = mysql_fetch_array ($result, MYSQL_NUM)) {

		// Set the new invoice No.
		$invoice_no = $num[0] + 1;

		switch ($_SESSION['payment_option']) {
			case 'Cheque':
				$os = 'Cheque Payment Pending';
				break;
			case 'Paypal':
				$os = 'Paypal Payment Pending';
				break;
			case 'Debit/Credit Card':
			    $os = 'Card Payment Pending';
			    break;
			default:
				$os = 'Waiting for Payment';
				break;
		}

		// Set Order status.
		$query = "
				SELECT order_status_id
				FROM customer_order_status
				WHERE order_status='$os'
				";
		$order_status = mysql_result (mysql_query($query), 0, 'order_status_id');

		// Add the record to the database.
		$query = "
			INSERT INTO customer_orders (customer_id, order_status_id, total, order_date, cart, invoice, shipping, vat_total, vat_invoice)
			VALUES ({$_SESSION['cid']}, $order_status, {$cartTotals['CART_TOTAL']}, NOW(), '$c', $invoice_no, {$cartTotals['POST_COST']}, {$cartTotals['VAT_TOTAL']}, $VatState)
		";
		
	} else {
		$error = TRUE;
	}

	// $result = mysql_query ($query)
	if ($error != TRUE) {

		// Send an email.
		// Set invoice variables.
		if ($invoice_tpl = file_get_contents ("{$_SERVER['DOCUMENT_ROOT']}/admin/modules/web_shop/invoice.txt")) {

			// add invoice no and date to invoice.
			$replace = '<!-- INVOICE -->';
			$with = "Order No: " . $invoice_no;
			$i = 	str_replace ($replace, $with, $i);

			$replace = '<!-- DATE -->';
			$with = "Date: " . date('F j, Y');
			$i = str_replace ($replace, $with, $i);

			// Add additional invoice info.
			$i .= "<p>Payment Method: " . $_SESSION['payment_option'] . "</p>";
			$i .= "<p>Additional Information:</p><p>" . $_SESSION['customer_note'] . "</p>";

			$title = "Purchase Order #$invoice_no From $merchant_name";
			$template = array (
                'TITLE' => $title,
                'NAME' => $merchant_name,
                'INVOICE' => $i,
				'COLLECT' => ($_SESSION['collect_instore']) ? '<p>Collect Order:- You will be notified when your order is ready</b></p>' : ''
            );

			$email_message = Utility::templateParser($invoice_tpl, $template, '#### ', ' ####');
			$email_subject = "Purchase Order form " . $merchant_name . ": Order #$invoice_no";

			// register order and email invoices.
			if ($result = mysql_query ($query)) {

				$oid = mysql_insert_id();

				// update hit stat.
				$query = "
					SELECT product_id, hits
					FROM products
					WHERE product_id IN (";
				foreach ($cartItems as $key => $value) {
					$query .= $key . ',';
				}
				$query = substr ($query, 0, -1) . ")";

				$result = mysql_query($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$p_hits = $row['hits'] + $cartItems[$row['product_id']]['Qty'];
					mysql_query ("UPDATE products SET hits=$p_hits WHERE product_id={$row['product_id']}");
				}

				//$sendMail = new SendMail($sendMailconfig);

				// mail invoice to customer.
				/*$sendMail->sendEmail(array(
					'from' => $sendMailconfig['address_list']['orders'],
					'to' => $_SESSION['customer_email'],
					'subject' => $email_subject,
					'html' => $email_message,
				));
    	        
    	        // now mail order to merchant.
				$sendMail->sendEmail(array(
					'to' => $sendMailconfig['address_list']['orders'],
					'from' => $_SESSION['customer_email'],
					'subject' => $email_subject,
					'html' => $email_message,
				));*/

				$email_sent = "<p>Your sales order receipt has been emailed to you.</p>";
                $email_sent = "<p>Your sales order receipt can't emailed to you at the moment. We have received your order. If Paying by credit card please telephone your card details to us. Thank you</p>";
				
			} else {
				$error = TRUE;
			}
		} else {
			$error = TRUE;
		}

		if ($error != TRUE) {
			$content .= "<p>Thank you for your order!</p>";
			$content .= "<p><span style=\"background-color:skyblue;\">You have chosen to pay by {$_SESSION['payment_option']}</span></p>";

			$content .= '<div><table>';

            switch ($_SESSION['payment_option']) {
                case 'Debit/Credit Card':

                    $content .= '<tr><td>';
                    $content .= '<p>To pay using your debit/credit card click on the link below</p>';
                    $content .= '<p><form action="'.$https.'/shop/credit_card.php" method="post">';
                    $content .= '<input type="hidden" name="oid" value="'.$oid.'" />';
                    //$content .= '<input type="hidden" name="invoicetotal" value="'.$invoicetotal.'" />';
                    //$content .= '<input type="hidden" name="email" value="'.$_SESSION['customer_email'].'" />';
                    $content .= '<input type="submit" class="submit" name="submit" value="Pay with Debit/Credit Card" />';
                    $content .= '</form></p>';
                    $content .= '</td></tr>';
                    break;

                case 'Cheque':
                    $address = $merchant_name . "<br />";
                    $address .= $merchant_address1 . "<br />";
                    if ($merchant_address2) $address .= $merchant_address2 . "<br
    />";
                    $address .= $merchant_city . "<br />";
                    $address .= $merchant_county . " ";
                    $address .= $merchant_post_code . "<br />";
                    $address .= $merchant_country;
                    $content .= '
                    <tr><td>
                    <p>Please make cheques payable to:
                    ';
                    $content .= $merchant_name;
                    $content .= '</p><p>And send it to:-</p>';
                    $content .= '<p style="border: 1px solid black; padding:3px;">'.$address.'</p>';
                    $content .= '</td></tr>';
                    break;

                case 'Telephone':
                    $content .= '<tr><td>';
                    $content .= '<p>To pay using your debit/credit card over the phone please call:-</p>';
                    $content .= '<p>'.$merchant_phone.'</p>';
                    $content .= '</td></tr>';
                    break;

                case 'Paypal':

                    $tree = new NestedTree('product_category', NULL, 'category', $dbc);

                    foreach ($cartItems as $item => $contents) {

                        $p = mysql_query("
                            SELECT category_id, product_name, short_description
                            FROM products
                            WHERE product_id=$item
                        ");
                        $pn = mysql_result($p, 0, 'product_name');
                        $pd = mysql_result($p, 0, 'short_description');
                        $catid = mysql_result($p, 0, 'category_id');

                        $category = NULL;
                        foreach ($tree->pathway($catid) as $id => $path) {

                            $category .= " - " . $path['category'];

                        }

                        $category = substr($category,3);

                        $_SESSION['pp_cart'][$pn]['item_name'] = $category . " - " . $pd;
                        $_SESSION['pp_cart'][$pn]['quantity'] = $cartItems[$item]['Qty'];
                        $_SESSION['pp_cart'][$pn]['amount'] = $cartItems[$item]['Price'];
                    }

                    if ($PaypalIPN == 1) {
                        require_once($_SERVER['DOCUMENT_ROOT'].'/shop/paypal/paypal_ipn.php');
                    } else {
                        $c = 1;

                        $content .= '<tr><td>';
                        $content .= '<p>to pay by Paypal please click on the button below:</p>';
                        $content .= '<p>N.B. you do not need a paypal account to pay via credit card, but we use paypal to clear all credit cards.</p>';
                        $content .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
                        $content .= '<input type="hidden" name="cmd" value="_cart" />';
                        $content .= '<input type="hidden" name="upload" value="1" />';
                        $content .= '<input type="hidden" name="business" value="'.$pp_merchant_id.'" />';
                        $content .= '<input type="hidden" name="cancel_return" value="'.$https.'/shop/paypal/cancel_order.php?oid='.$oid.'" />';
                        $content .= '<input type="hidden" name="return" value="'.$https.'/shop/paypal/paypal_return.php?oid='.$oid.'" />';
                        $content .= '<input type="hidden" name="rm" value="2" />';
                        $content .= '<input type="hidden" name="invoice" value="'.$invoice_no.'" />';
                        $content .= '<input type="hidden" name="image_url" value="'.$https.'/template/charisma.gif" />';

                        // $content .= all items in the cart.
                        foreach ($_SESSION['pp_cart'] as $item => $contents) {

                            $content .= "<input type=\"hidden\" name=\"item_number_" . $c . "\" value=\"" . $item . "\" />\r\n";

                            foreach ($contents as $name => $value) {
                                $content .= "<input type=\"hidden\" name=\"" . $name . "_" . $c . "\" value=\"" . $value . "\" />\r\n";
                            }
                            $c++;
                        }

                        $content .= '<input type="hidden" name="shipping_1" value="'.$cartTotals['POST_COST'].'" />';
                        $content .= '<input type="hidden" name="currency_code" value="'.$pp_currency.'" />';
                        $content .= '<input type="submit" class="submit" name="submit" Value="Pay with Paypal" />';
                        $content .= '</form>';
                        $content .= '</td></tr>';
                    }
                    break;
            }
			$content .= "</table></div>";

			$content .= '<div>'.$email_sent.'</div>';
			$content .= '<div>Your sales order receipt is below. You can print this page for your reference.</div>';
			$content .= '<div>'.$i.'</div>';

			// Empty the cart and reset the session.
            $cart->deleteCart(false);

			foreach ($_SESSION as $key => $value) {
				if ($key != "cid" && $key != "first_name") {
					unset ($_SESSION[$key]);
				}
			}

		} else {

			$content .= "<div><p>Due to a system error your order could not be placed.</p><p>Please try again later.</p></div>";

		}

	} else {

		$content .= "<div><p>Due to a system error your order could not be placed.</p><p>Please try again later.</p></div>";

	}

	mysql_close(); // Close the database connection.

}  else {

	ob_end_clean(); // Delete the buffer.
    header ("Location: $merchant_website/index.php");
	exit();

}


// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
