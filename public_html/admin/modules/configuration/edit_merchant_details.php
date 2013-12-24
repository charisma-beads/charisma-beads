<?php // index.php (administration side) Friday, 8 April 2005
// This is the edit merchant details for the admin side of the site.

// Set the page title.
$page_title = "Edit Merchant Details";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	if (isset ($_POST['submit'])) {

		$file = "{$_SERVER['DOCUMENT_ROOT']}/../data/merchant_data.php";
		print "<p><a href=\"index.php\">Back to Overview</a></p>";

        Utility::edit_details ($file);

	} else {
		?>
		<p>
			<a href="index.php">Back to Overview</a>
		</p>
	 	<div class="box">

		<form action="edit_merchant_details.php" method="post">

			<table border="1" cellspacing="2" cellpadding="2">

				<tr>
					<td class="bold">Company Name:</td>
					<td><input type="text" name="merchant_name" size="40" maxlength="40" value="<?php print $merchant_name; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">First Name:</td>
					<td><input type="text" name="merchant_first_name" size="15" maxlength="15" value="<?php print $merchant_first_name; ?>" /></td>
				</tr>

    			<tr>
					<td class="bold">Last Name:</td>
					<td><input type="text" name="merchant_last_name" size="30" maxlength="30" value="<?php print $merchant_last_name; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Address 1:</td>
					<td><input type="text" name="merchant_address1" size="30" maxlength="30" value="<?php print $merchant_address1; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Address 2:</td>
					<td><input type="text" name="merchant_address2" size="30" maxlength="30" value="<?php print $merchant_address2; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Town/City:</td>
					<td><input type="text" name="merchant_city" size="30" maxlength="30" value="<?php print $merchant_city; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">County:</td>
					<td><input type="text" name="merchant_county" size="30" maxlength="30" value="<?php print $merchant_county; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Post Code:</td>
					<td><input type="text" name="merchant_post_code" size="10" maxlength="10" value="<?php print $merchant_post_code; ?>" /></td>
				</tr>

				<tr>
					<td class="bold">Telephone No:</td>
					<td><input type="text" name="merchant_phone" size="20" maxlength="20" value="<?php print $merchant_phone; ?>" /></td>
				</tr>

	   			<tr>
				 	<td class="bold">Email:</td>
				 	<td><input type="text" name="merchant_email" size="40" maxlength="40" value="<?php print $merchant_email; ?>" /></td>
				</tr>

				<tr>
				 	<td class="bold">Website URL:</td>
				 	<td><input type="text" name="merchant_website" size="40" maxlength="40" value="<?php print $merchant_website; ?>" /></td>
				</tr>

				<tr>
				 	<td class="bold">Secure Website URL:</td>
				 	<td><input type="text" name="https" size="40" maxlength="40" value="<?php print $https; ?>" /></td>
				</tr>

				<tr>
				 	<td class="bold">Site Status:</td>
				 	<td><input type="text" name="deploy" size="40" maxlength="40" value="<?php print $deploy; ?>" /></td>
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