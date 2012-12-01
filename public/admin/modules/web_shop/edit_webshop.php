<?php // edit_webshop.php (administration side) Friday, 8 April 2005
// This is the edit webshop details for the admin side of the site.

// Set the page title.
$page_title = "Edit Webshop Details";

$custom_headtags = '
	<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "textareas",
 			theme : "simple"
		});
	</script>
	<!-- /TinyMCE -->
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	if (isset ($_POST['submit'])) {

		$file = "{$_SERVER['DOCUMENT_ROOT']}/../data/webshop_config.php";
		print "<p><a href=\"index.php\">Back to Overview</a></p>";

        Utility::edit_details ($file);

	} else {

		include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/webshop_config.php');
		?>
		<p>
			<a href="index.php">Back to Overview</a>
		</p>
	 	<div class="box">

		<form action="edit_webshop.php" method="post">

			<table border="1" cellspacing="2" cellpadding="2">

				<tr>
				<td class="bold">Orders Email:</td>
				<td><input type="text" name="orders_email" size="30" value="<?php print $orders_email; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Post State:</td>
					<td class="bold">By Weight:<input type="radio" name="PostState" value="1"
					<?php
					if ($PostState == 1) {
						print 'checked="checked"';
					}
					?>
					/>
					By Invoice Total:<input type="radio" name="PostState" value="0"
					<?php
					if ($PostState == 0) {
						print 'checked="checked"';
					}
					?>
					/></td>
				</tr>

				<tr>
					<td class="bold">Stock Control:</td>
					<td class="bold">On:<input type="radio" name="StockControl" value="1"
					<?php
					if ($StockControl == 1) {
						print 'checked="checked"';
					}
					?> />

						Off:<input type="radio" name="StockControl" value="0"
					<?php
					if ($StockControl == 0) {
						print 'checked="checked"';
					}
					?>
					/>
						</td>
				</tr>

				<tr>
					<td class="bold">Vat State:</td>
					<td class="bold">Yes:<input type="radio" name="VatState" value="1"
					<?php
					if ($VatState == 1) {
						print 'checked="checked"';
					}
					?>  onclick="show(document.getElementById('VatNumber'));" />
					No:<input type="radio" name="VatState" value="0"
					<?php
					if ($VatState == 0) {
						print 'checked="checked"';
					}
					?>  onclick="hide(document.getElementById('VatNumber'));" />
					</td>
				</tr>

				<tr id="VatNumber" <?php if ($VatState == 0) print 'style="display:none;"'; ?> >
					<td class="bold">Vat Reg number:</td>
					<td><input type="text" name="VatNumber" size="30" maxlength="30" value="<?php print $VatNumber; ?>" /></td>
				</tr>

    			<tr>
					<td class="bold">Pay by Check:</td>
					<td class="bold">Yes:<input type="radio" name="PayCheck" value="1"
					<?php
					if ($PayCheck == 1) {
						print 'checked="checked"';
					}
					?> />
					No:<input type="radio" name="PayCheck" value="0"
					<?php
					if ($PayCheck == 0) {
						print 'checked="checked"';
					}
					?> /></td>
				</tr>

				<tr>
					<td class="bold">Pay by Cedit Card:</td>
					<td class="bold">Yes:<input type="radio" name="PayCreditCard" value="1"
					<?php
					if ($PayCreditCard == 1) {
						print 'checked="checked"';
					}
					?> />
					No:<input type="radio" name="PayCreditCard" value="0"
					<?php
					if ($PayCreditCard == 0) {
						print 'checked="checked"';
					}
					?> /></td>
				</tr>

				<tr>
					<td class="bold">Pay By Phone:</td>
					<td class="bold">Yes:<input type="radio" name="PayPhone" value="1"
					<?php
					if ($PayPhone == 1) {
						print 'checked="checked"';
					}
					?> />
					No:<input type="radio" name="PayPhone" value="0"
					<?php
					if ($PayPhone == 0) {
						print 'checked="checked"';
					}
					?> /></td>
				</tr>

				<tr>
					<td class="bold">Pay by Paypal:</td>
					<td class="bold">Yes:<input type="radio" name="PayPaypal" value="1"
					<?php
					if ($PayPaypal == 1) {
						print 'checked="checked"';
					}
					?>  onclick="show(document.getElementById('Paypal'));" />
					No:<input type="radio" name="PayPaypal" value="0"
					<?php
					if ($PayPaypal == 0) {
						print 'checked="checked"';
					}
					?>  onclick="hide(document.getElementById('Paypal'));" />
					</td>
				</tr>

				<tr id="Paypal" <?php if ($PayPaypal == 0) print 'style="display:none;"'; ?> >
					<td colspan="2">
				<table>
				<tr>
					<td class="bold">Paypal Email:</td>
					<td><input type="text" name="pp_merchant_id" size="30" maxlength="30" value="<?php print $pp_merchant_id; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Paypal Currency:</td>
					<td>
					<select name="pp_currency">
					<option>Choose Currency</option>
					<?php
					$query = "
						SELECT currency, code
						FROM paypal_currency
						ORDER BY currency_id
						";
					$result = mysql_query ($query);

					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {

						print "<option value=\"{$row['code']}\" ";

						if ($pp_currency == $row['code']) {

							print "selected=\"selected\" ";
						}

						print ">{$row['currency']}</option>\r\n";

					}
					?>
					</select>
					</td>
					</tr>

					<tr>
					<td class="bold">Paypal IPN:</td>
					<td>Off: <input type="radio" name="PaypalIPN" value="0"
					<?php
						if ($PaypalIPN == 0) {
						print 'checked="checked"';
					} ?>
					/> ON: <input type="radio" name="PaypalIPN" value="1"
					<?php
						if ($PaypalIPN == 1) {
						print 'checked="checked"';
					} ?>
					/></td>
					</tr>

					</table></td>
				</tr>

				<tr>
					<td class="bold">Number of products to display per page:</td>
					<td><input type="text" name="ProductDisplay" size="3" maxlength="3" value="<?php print $ProductDisplay; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Shop Alert:</td>
					<td class="bold">On:<input type="radio" name="ShopAlert" value="1"
					<?php
					if ($ShopAlert == 1) {
						print 'checked="checked"';
					}
					?> />
					Off:<input type="radio" name="ShopAlert" value="0"
					<?php
					if ($ShopAlert == 0) {
						print 'checked="checked"';
					}
					?> /></td>
				</tr>

				<tr>
					<td class="bold">Shop Alert Text:</td>
                    <td class="bold"><textarea cols="10" rows="10" name="ShopAlertText" id="ShopAlertText"><?=$ShopAlertText;?></textarea></td>
				</tr>

				<tr>
					<td colspan="2" style="text-align:center;"><input type="submit" name="submit" value="Update Details" /></td>
				</tr>

			</table>

		</form>
		</div>
	<?php
	}
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>