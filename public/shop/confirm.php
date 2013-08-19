<?php // confirm.php Tuesday, 3 May 2005
// This is the Checkout page for the site.
// Checkout process 2/3.

// Set the page title and include the HTML header.
$page_title = "Checkout";
// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

# *** Confirm the log-in and find the customer ID. *** #

if (isset($_SESSION['cid']) && $cart->getNumCartItems() > 0 && ($_POST['stage'] == 1 || $_POST['stage'] == 2)) {

	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', array ($merchant_db_host, $merchant_db_user, $merchant_db_password, $merchant_db_name));

	$content .= "<h1>Sales Order: Step 2 of 3</h1>";

	$PayOptions = array();
    if ($PayCreditCard) $PayOptions[] = "Debit/Credit Card";
	if ($PayPaypal) $PayOptions[] = "Paypal";
	if ($PayCheck) $PayOptions[] = "Cheque";
	if ($PayPhone) $PayOptions[] = "Telephone";

	// Validate form when submitted.
	if ($_POST['submit'] == "Submit Order" && $_POST['stage'] == 2) {

		$error = NULL;

		if ($_POST['terms'] == 1) {

			$_SESSION['terms'] = "agree";
			
			$_SESSION['collect_instore'] = (isset($_POST['collectInStore'])) ? true : false;

			if (isset($_POST['payment_option'])) {

				$_SESSION['payment_option'] = $_POST['payment_option'];

				if ($_POST['customer_note']) {
					$_SESSION['customer_note'] = $_POST['customer_note'];
				} else {
					$_SESSION['customer_note'] = "none";
				}
				
				print_r($_SESSION);

                Utility::go('final.php?stage='.$_POST['stage']);

			} else {

				$error .= "<p>You must Choose one of these payment options to order:</p>";

				foreach ($PayOptions as $option) {
					$error .= "<p>$option</p>";
				}
			}
		} else {
			$error .= "<p>You must agree to the terms of Service to order</p>";
		}

		if (isset($error)) {

			$content .= '
			<div id="error_msg" style="color:red; font-size:18px; font-weight:bold; padding:10px; margin-left:auto; margin-right:auto;">'.$error.'</div>';
		}
	}

	$i = new Invoice($dbc);

    $i->display_bottom = "";
    if ($VatState == 1) $i->display_bottom .= "<tr><td align=\"center\" colspan=\"2\">VAT Reg: $VatNumber</td></tr>";
	$i->display_bottom .= "<tr><td align=\"center\" colspan=\"2\">Registered at Companies House, register number 6367772</td></tr>";
	$i->display_bottom .= "<tr><td align=\"center\" colspan=\"2\">Registered office address: Unit 2F, 80/81 Walsworth Road, Hitchin, Hertfordshire, SG4 9SX
</td></tr>";

	$content .= $i->displayInvoice($_SESSION['cid'], $cart);

	//$_SESSION['invoice'] = $i->displayInvoice($_SESSION['cid'], $cart);

	//$_SESSION['customer_email'] = $CIA['email'];
	// Register the totals to the session.
	//$_SESSION['total'] = number_format ($Total, 2);
	//$_SESSION['vat_total'] = number_format (($TaxTotal + $PostTax), 2);

	// Create a form.
	$content .= '
	<div>
	<form action="'.$_SERVER['PHP_SELF'].'" method="post">

	<div style="margin-bottom:10px;">
		<p>Choose a payment option:</p>
		';
		$i = NULL;

		foreach ($PayOptions as $option) {
			$i .= "<p><input type=\"radio\" name=\"payment_option\" value=\"$option\" /><b>&nbsp;Pay by $option";
			$i .= "</b></p>\r\n";
		}

	$content .= '<p>'.$i.'</p>
	</div>';
	
	if ($CollectInstore) {
		$content .= '<p><input type="checkbox" name="collectInStore" value="1" /><b>&nbsp;Please click the box if you would like to collect your order.</b></p>';
		$content .= "<p>When collecting, postage will be removed from total</p>";
	}

	$content .= '<div style="margin-bottom:10px;">
		<p>Additional requirements:</p>
		<p><textarea name="customer_note" rows="6" cols="50">';
    if (isset($_POST['customer_note'])) $content .= $_POST['customer_note'];
    $content .= '</textarea></p></div>

	<div style="margin-bottom:10px;">
		<p>I agree to the Terms of Service <select name="terms"><option>Select</option><option value="1"
			';
			$content .= (isset($_SESSION['accept_terms'])) ? 'selected="selected"' : null;
            $content .= '
			>Yes</option><option value="0">No</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="#" id="read_terms">Click here to read terms</a></span></p>
	</div>
	<div id="show_terms" style="height:100px; width:500px; padding-left:20px; padding-right:20px; overflow:auto;margin-left:100px;margin-top:20px;border:1px solid black;">
		';
            include_once($_SERVER['DOCUMENT_ROOT'] . '/shop/terms.php');

        $content .= '</div>

	<div>
		<input type="hidden" name="stage" value="2" />
		<input class="submit" type="submit"  name="submit" value="Submit Order" />
	</div>
	</form>
	</div>
    ';

} else {

	ob_end_clean(); // Delete the buffer.
    header ("Location: $merchant_website/index.php");
	exit();

}

mysql_close(); // Close the database connection.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>
