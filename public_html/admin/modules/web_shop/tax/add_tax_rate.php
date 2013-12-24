<?php 
// view_order.php Tuesday, 3 May 2005
// This is the add catagory page for admin.
	  
// Set the page title.
$page_title = "Add Tax Rate";
// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');
	  
// Print a message based on authentication.
if (!$authorized) {
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
						  
	require_once ('menu_links.php');
						  
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";
						  
	if (isset ($_POST['submit'])) {	
						  
		// Valadate the data.
		if ($_POST['submit'] == "Add Tax Rate") {
						  
			$error = NULL;
			
			if ($_POST['tax_rate'] == 0) $_POST['tax_rate'] = number_format ($_POST['tax_rate'], 2);
								  
			if (is_numeric ($_POST['tax_rate'])) {
				
				$tax_rate = escape_data (trim ($_POST['tax_rate']));
				if ($tax_rate > 0) $tax_rate = 1 + ($tax_rate / 100);
			} else {
				$tax_rate = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a tax rate<span></p>";
			}
												  
			// If all is well.
			if ($tax_rate >= 0) {
												  
				// Check if tax code is availiable.
				$query = "
					SELECT tax_rate_id
					FROM tax_rates
					WHERE tax_rate=$tax_rate
				";
				
				$result = mysql_query ($query);
												  
				if (mysql_num_rows($result) == 0) {
												  
					// Add Tax code.
					$query = "
						INSERT INTO tax_rates (tax_rate)
						VALUES ($tax_rate)
					";
					$result = mysql_query ($query);
					
					//go ('tax_rates.php');
												  
				} else {
					print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This tax rate already exists<span></p>";
				}
														  
			} else {
				?>
				<div class="box">
					<?=$error?>
				</div>
				<?php
			}
															   
		}
															   
	} else {
															   
		?>
		<div class="box">
			<table cellspacing="2" cellpadding="2">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
																	  
					<tr><td align="right"><b>Tax Rate</b></td><td><input type="text" name="tax_rate" value="" maxlength="5" size="5" />&#037;</td></tr>
																	
					<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Tax Rate" /></td></tr>
				</form> 
			</table>
		</div>
		<?php
															 
	}
															 
	print "</td></tr></table>";
	mysql_close(); // Close the database connection.
												 
}
												 
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
												 
?>