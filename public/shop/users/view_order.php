<?php

// login.php Tuesday, 5 April 2005
// This page allows logged-in users to change their details.

// Set the page title.
$page_title = "View Order";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
//include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/NestedTree.class.php');

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['cid'])) {

header ("Location: $merchant_website/index.php");

} else {

	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);

	$content .= "<p><a href=\"index.php\">Back to My Account</a></p>";

	if (isset ($_GET['oid'])) { // Come from view_customers.php.

		$query = "
			SELECT cart, vat_total, total, invoice, shipping, DATE_FORMAT(order_date, '%D %M %Y') AS date, order_status, vat_invoice
			FROM customer_orders, customers, customer_order_status
			WHERE customers.customer_id = customer_orders.customer_id
			AND customer_orders.order_status_id=customer_order_status.order_status_id
			AND customer_orders.order_id = {$_GET['oid']}
		";
		$result = mysql_query ($query);
		$row = mysql_fetch_array ($result, MYSQL_ASSOC);

		$order = unserialize (stripslashes ($row['cart']));
		$shipping = $row['shipping'];
		$vat_total = $row['vat_total'];
		$total = $row['total'];
		$invoice_no = $row['invoice'];
		$date = $row['date'];
		$order_status = $row['order_status'];
		$vat_invoice = $row['vat_invoice'];

		// Retrieve all of the information for the products in the cart.
		$query = '
			SELECT category_id, product_id, size_id, product_name, short_description, enabled, vat_inc
			FROM products
			WHERE product_id IN (';
		foreach ($order as $key => $value) {
			$query .= $key . ',';
		}
		$query = substr ($query, 0, -1) . ')
			ORDER BY category_id, product_name ASC';
		$result = mysql_query ($query);

		// Create a table and a form.
		$i = "<table id=\"invoice\" style=\"width:100%;font-size:10pt;\">\r\n";
		$i .= "<tr>\r\n";

		// Customer Invoice Address & Delivery Address.
		$CIA = "
		SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) as name, address1, address2, address3, city, county, post_code, country, phone, email, delivery_address_id, delivery_address
		FROM customers, countries, customer_prefix
		WHERE customer_id='{$_SESSION['cid']}'
		AND customers.country_id=countries.country_id
		AND customers.prefix_id=customer_prefix.prefix_id
		LIMIT 1";

		$CIA = mysql_query($CIA);
		$CIA = mysql_fetch_array ($CIA, MYSQL_ASSOC);

		if ($CIA['delivery_address'] == "Y") {
			$CDA = "
			SELECT *
			FROM customer_delivery_address, countries
			WHERE customer_id='{$_SESSION['cid']}'
			AND customer_delivery_address.country_id=countries.country_id
			LIMIT 1";
			$CDA = mysql_query($CDA);
			$CDA = mysql_fetch_array ($CDA, MYSQL_ASSOC);
		}

		// Display Customer Address.
		$i .= "<td>\r\n";
		$i .= "<table>\r\n";
		$i .= "<tr>\r\n";
		$i .= "<td valign=\"top\">\r\n";
		$i .= "<table style=\"border: 1px solid black;\">\r\n";
		$i .= "<tr><td style=\"background-color:skyblue;\">Address</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['address1']},</td></tr>\r\n";
		if ($CIA['address2']) $i .= "<tr><td>{$CIA['address2']},</td></tr>\r\n";
		if ($CIA['address3']) $i .= "<tr><td>{$CIA['address3']},</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['city']},</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['county']}.</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['post_code']}</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['country']}</td></tr>\r\n";
		$i .= "<tr><td>Tel: {$CIA['phone']}</td></tr>\r\n";
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";
		$i .= "<td valign=\"top\">\r\n";
		$i .= "<table style=\"border:1px solid black;\">\r\n";
		$i .= "<tr><td style=\"background-color:skyblue; text-align:left;\">Delivery Address</td></tr>\r\n";
		if ($CIA['delivery_address'] == "Y") {
			$i .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['address1']}</td></tr>\r\n";
			if ($CDA['address2']) $i .= "<tr><td>{$CDA['address2']},</td></tr>\r\n";
			if ($CDA['address3']) $i .= "<tr><td>{$CDA['address3']},</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['city']}, {$CDA['county']}, {$CDA['post_code']}</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['country']}</td></tr>\r\n";
			$i .= "<tr><td>Tel: {$CDA['phone']}</td></tr>\r\n";
		} else {
			$i .= "<tr><td style=\"font-weight:bold;\">Same as Address</td></tr>\r\n";
		}
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";
		$i .= "</tr>\r\n";
		$i .= "<tr><td colspan=\"2\">Email: {$CIA['email']}</td></tr>\r\n";
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";

		// Display Merchant Address.
		$i .= "<td valign=\"top\" align=\"right\">\r\n";
		$i .= "<table style=\"border: 1px solid black;\">\r\n";
		$i .= "<tr><td style=\"background-color:skyblue;\">From</td></tr>\r\n";
		$i .= "<tr><td>$merchant_name</td></tr>\r\n";
		$i .= "<tr><td>$merchant_address1,</td></tr>\r\n";
		if ($merchant_address2) $i .= "<tr><td>$merchant_address2,</td></tr>\r\n";
		$i .= "<tr><td>$merchant_city,</td></tr>\r\n";
		$i .= "<tr><td>$merchant_county.</td></tr>\r\n";
		$i .= "<tr><td>$merchant_post_code</td></tr>\r\n";
		//$i .= "<tr><td>$merchant_country</td></tr>\r\n";
		$i .= "<tr><td>$merchant_email</td></tr>\r\n";
		$i .= "<tr><td>Telephone: $merchant_phone</td></tr>";
		$i .= "<tr><td>Order No: $invoice_no</td></tr>\r\n";
		$i .= "<tr><td>Date: $date</td></tr>\r\n";
		$i .= "</table>\r\n";
		$i .= "</td>";
		$i .= "</tr>\r\n";

		// Display products.
		$i .= "<tr>\r\n";
		$i .= "<td colspan=\"2\">\r\n";
		$i .= "<table border=\"0\" cellspacing=\"3\" cellpadding=\"3\" style=\"width:100%;\">\r\n";
		$i .= "<tr>\r\n";
		$i .= "<td style=\"text-align:left; width:30%; background-color:skyblue;\"><b>Product</b></td>\r\n";
		$i .= "<td style=\"text-align:left; width:30%; background-color:skyblue;\"><b>Description</b></td>\r\n";
		$i .= "<td style=\"text-align:left; width:10%; background-color:skyblue;\"><b>Price</b></td>\r\n";
		if ($vat_invoice == 1) $i .= "<td style=\"text-align:left; width:10%; background-color:skyblue;\"><b>Vat</b></td>\r\n";
		$i .= "<td style=\"text-align:left; width:10%; background-color:skyblue;\"><b>Qty</b></td>\r\n";
		$i .= "<td style=\"text-align:left; width:10%; background-color:skyblue;\"><b>Total</b></td>\r\n";
		$i .= "</tr>\r\n";

		// $content .= each item.

		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {

			$category = NULL;
			foreach ($tree->pathway($row['category_id']) as $id => $path) {
				$category .= " - " . $path['category'];
			}

			$category = substr($category,3);

			// Calculate the total and subtotals.
			$subtotal = $order[$row['product_id']]['Qty'] * ($order[$row['product_id']]['Price'] + $order[$row['product_id']]['vat']);

			// $content .= the row.
			$i .= "<tr>\r\n";
			$i .= "<td style=\"text-align:left; border-bottom:1px solid black;\">{$row['product_name']}</td>\r\n";
			$i .= "<td style=\"text-align:left; border-bottom:1px solid black;\">$category&nbsp;-&nbsp;{$row['short_description']}</td>\r\n";
			$i .= "<td style=\"text-align:left; border-bottom:1px solid black;\">&pound;" . number_format ($order[$row['product_id']]['Price'], 2) . "</td>\r\n";
			if ($vat_invoice == 1) $i .= "<td style=\"text-align:left; border-bottom:1px solid black;\">&pound;" . number_format ($order[$row['product_id']]['vat'], 2) . "</td>\r\n";
			$i .= "<td style=\"text-align:left; border-bottom:1px solid black;\">{$order[$row['product_id']]['Qty']}</td>\r\n";
			$i .= "<td style=\"text-align:right; border-bottom:1px solid black;\">&pound;" . number_format ($subtotal, 2) . "</td>\r\n";
			$i .= "</tr>\r\n";

		} // Endof the WHILE loop.

		$span = ($vat_invoice == 1) ? 3 : 2;
		// $content .= the footer and close the table and the form.
		$i .= "<tr>\r\n";
		$i .= "<td colspan=\"$span\" style=\"text-align:right;\">&nbsp;</td><td  colspan=\"2\" style=\"background-color:skyblue; text-align:right;\"><b>Postage:</b></td>\r\n";
		$i .= "<td style=\"text-align:right; border-bottom:1px solid black;\">&pound;$shipping";
		$i .= "</td>\r\n";
		$i .= "</tr>\r\n";

		if ($vat_invoice) {
			$i .= "<tr>\r\n";
			$i .= "<td colspan=\"$span\" style=\"text-align:right;\">&nbsp;</td><td  colspan=\"2\" style=\"background-color:skyblue; text-align:right;\"><b>Vat Total:</b></td>\r\n";
			$i .= "<td style=\"text-align:right; border-bottom:1px solid black;\">&pound;" . number_format ($vat_total, 2) . "</td>\r\n";
			$i .= "</tr>\r\n";
		}

		$i .= "<tr>\r\n";
		$i .= "<td colspan=\"$span\" style=\"text-align:right;\">&nbsp;</td><td colspan=\"2\" style=\"background-color:skyblue; text-align:right;\"><b>Total:</b></td>\r\n";
		$i .= "<td style=\"text-align:right; border-bottom:1px solid black;\">&pound;" . number_format ($total, 2) . "</td>\r\n";
		$i .= "</tr>\r\n";
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";
		$i .= "</tr>\r\n";
		if ($vat_invoice == 1) $i .= "<tr><td align=\"center\" colspan=\"2\">VAT Reg: $VatNumber</td></tr>";
		$i .= "</table>\r\n";

		// register paypal shopping cart.

		if ($PayPaypal == 1 && ($order_status == "Waiting for Payment" || $order_status == "Paypal Payment Pending" || $order_status == "Cheque Payment Pending" || $order_status == "Card Payment Pending")) {
			$c = 1;
			foreach ($order as $item => $contents) {

				$p = mysql_query("
					SELECT category_id, product_name, short_description
					FROM products
					WHERE product_id=$item
				");

				$cat_id = mysql_result($p, 0, 'category_id');
				$pn = mysql_result($p, 0, 'product_name');
				$pd = mysql_result($p, 0, 'short_description');

				$category = NULL;
				foreach ($tree->pathway($cat_id) as $id => $path) {
					$category .= " - " . $path['category'];
				}

				$category = substr($category,3);

				$pp_cart[$pn]['item_name'] = $category . ' - ' . $pd;
				$pp_cart[$pn]['quantity'] = $order[$item]['Qty'];
				$pp_cart[$pn]['amount'] = $order[$item]['Price'] + $order[$item]['vat'];
			}

			//$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
			
			$content .= '<div>';
			$content .= '<p>To pay using your credit/debit card click on the button below</p>';
			$content .= '<p><form action="'.$https.'/shop/credit_card.php" method="post">';
			$content .= '<input type="hidden" name="oid" value="'.$_GET['oid'].'" />';
			//$content .= '<input type="hidden" name="invoicetotal" value="'.$invoicetotal.'" />';
			//$content .= '<input type="hidden" name="email" value="'.$_SESSION['customer_email'].'" />';
			$content .= '<input type="submit" class="submit" name="submit" value="Pay with Debit/Credit Card" />';
			$content .= '</form></p>';
			$content .= '</div>';

			$content .= '
			<p>To pay by Paypal please click on the button below:</p>
			<form action="'.$paypal_url.'>" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_cart" />
			<input type="hidden" name="upload" value="1" />
			<input type="hidden" name="business" value="'.$pp_merchant_id.'" />
			';
			// print all items in the cart.
			foreach ($pp_cart as $item => $contents) {

				$content .= "<input type=\"hidden\" name=\"item_number_" . $c . "\" value=\"" . $item . "\" />\r\n";

				foreach ($contents as $name => $value) {

					$content .= "<input type=\"hidden\" name=\"" . $name . "_" . $c . "\" value=\"" . $value . "\" />\r\n";

				}

				$c++;
			}

			$content .= '
			<input type="hidden" name="notify_url" value="'.$https.'/shop/paypal/paypal_ipn.php?action=ipn&oid='.$_GET['oid'].'" />
			<input type="hidden" name="return" value="'.$https.'/shop/paypal/paypal_ipn.php?action=success&oid='.$_GET['oid'].'" />
			<input type="hidden" name="cancel_return" value="'.$https.'/shop/paypal/paypal_ipn.php?action=cancel&oid='.$_GET['oid'].'" />
			<input type="hidden" name="image_url" value="'.$https.'/template/charisma.gif" />
			<input type="hidden" name="shipping_1" value="'.$shipping.'" />
			<input type="hidden" name="currency_code" value="'.$pp_currency.'" />
			<input type="hidden" name="rm" value="2" />
			<input type="hidden" name="invoice" value="'.$invoice_no.'" />
			<input type="hidden" name="custom" value="'.$_GET['oid'].'" />

			<!-- prepopulate paypal $CIA -->
			';
			$name = explode(" ", $CIA['name']);
			$CIA['first_name'] = $name[1];
			$CIA['last_name'] = $name[2];
			$content .= '
			<input type="hidden" name="first_name" value="'.$CIA['first_name'].'" />
			<input type="hidden" name="last_name" value="'.$CIA['last_name'].'" />
			<input type="hidden" name="address1" value="'.$CIA['address1'].'" />
			<input type="hidden" name="address2" value="'.$CIA['address2'].'" />
			<input type="hidden" name="address3" value="'.$CIA['address3'].'" />
			<input type="hidden" name="city" value="'.$CIA['city'].'" />
			<input type="hidden" name="state" value="'.$CIA['county'].'" />
			<input type="hidden" name="zip" value="'.$CIA['post_code'].'" />
			<input type="hidden" name="email" value="'.$CIA['email'].'" />
			<input type="hidden" name="night_phone_a" value="44" />
			<input type="hidden" name="night_phone_b" value="'.$CIA['phone'].'" />
			<input type="hidden" name="country" value="GB" />

			<input type="submit" class="submit" name="submit" Value="Pay with Paypal" />
			</form>
			';
			
			$content .= "<p>To pay by telephone: " . $merchant_phone;
		}

		$content .= $i;

	} else {// Redirect to index if didn't come from view_customers.php.

		ob_end_clean();
		header ('Location: http://' . $merchant_website . '/index.php.');
		exit();

	}

} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
