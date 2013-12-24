<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Tax Code";

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
	 	
		// Cancel.
		if ($_POST['submit'] == "Cancel") {
		
            Utility::go ('index.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$tcid = $_POST['tcid'];
			
			$query = "
				DELETE FROM tax_codes
				WHERE tax_code_id=$tcid
			";
			//print $query;
			$result = mysql_query ($query);
			
			// Update product_lines.
			$query = "
				UPDATE products
				SET tax_code_id=0
				WHERE tax_code_id=$tcid
			";
			//print $query;
			$result = mysql_query ($query);
				
            Utility::go ('index.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT tax_rate, tax_code, description
			FROM tax_codes, tax_rates
			WHERE tax_code_id={$_GET['tcid']}
			AND tax_codes.tax_rate_id=tax_rates.tax_rate_id
		";
		$result = mysql_query ($query);
		$tax_rate = mysql_result ($result, 0, 'tax_rate');
		$tax_code = mysql_result ($result, 0, 'tax_code');
		$description = mysql_result ($result, 0, 'description');
		
		if ($tax_rate > 0) {
			$tax_rate = substr ($tax_rate, 2);
			$tax_rate = substr ($tax_rate, 0, 2) . "." . substr ($tax_rate, -1);
			if (substr ($tax_rate, 0, 1) == 0) {
				$tax_rate = substr ($tax_rate, 1);
			}
			
			$tax_rate = number_format ($tax_rate, 2);
			
		} else {
			$tax_rate = number_format ($tax_rate, 2);
		}
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this tax code will orphan all the product tax codes belonging to this tax code</span></td></tr>
		<tr><td align="right"><b>Tax Code</b></td><td><?=$tax_code?></td></tr>
		<tr><td align="right"><b>Tax Rate</b></td><td><?=$tax_rate?></td></tr>
		<tr><td align="right"><b>Tax Description</b></td><td><?=$description?></td></tr>
		<input type="hidden" name="tcid" value="<?=$tax_code?>" />
		<tr><td align="center"><input type="submit" name="submit" value="Delete" /></td><td align="center"><input type="submit" name="submit" value="Cancel" /></td></tr>
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