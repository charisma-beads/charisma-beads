<?php // index.php (administration side) Friday, 8 April 2005
// This is the Merchant Details page for the admin side of the site.

// Set the page title.
$page_title = "Configuration";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	?>
	<table>
		<tr>
			<td valign="top">
				<table>
					<tr>
						<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="edit_merchant_details.php" class="Link">:: Edit Merchant Details</a></td>
					</tr>	
					<tr>
						<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="change_login.php" class="Link">:: Change Login Details</a></td>
					</tr>
				</table>
			</td>
			<td>
				<div class="box">
				<table border="1" cellspacing="2" cellpadding="2">
					<tr>
						<td class="bold">Company Name:</td>
						<td><?php print $merchant_name; ?></td>
					</tr>
					<tr>
						<td class="bold">Name:</td>
						<td><?php print $merchant_first_name . " " . $merchant_last_name; ?></td>
					</tr>	
					<tr>
						<td class="bold">Email</td>
						<td><?php print $merchant_email; ?></td>
					</tr>
					<tr>
						<td class="bold">Website Url:</td>
						<td><?php print $merchant_website; ?></td>	
					</tr>
				</table>
				</div>
			</td>
		</tr>
	</table>
	
	
	


	<?php
									  
}
?>	

<?php
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>