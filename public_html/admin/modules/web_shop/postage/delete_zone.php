<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Zone";

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
			
			$pzid = $_POST['pzid'];
			
			$query = "
					DELETE FROM post_zones
					WHERE post_zone_id=$pzid
					";
			
			$result = mysql_query ($query);
			// Update countries and post costs.
			$query = "
					UPDATE countries
					SET post_zone_id=0
					WHERE post_zone_id=$pzid
					";
			
			$result = mysql_query ($query);
			
			$query = "
					UPDATE post_costs
					SET post_zone_id=0
					WHERE post_zone_id=$pzid
					";
			
			$result = mysql_query ($query);
				
            Utility::go ('index.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT zone, tax_code
			FROM post_zones, tax_codes
			WHERE post_zone_id={$_GET['pzid']}
			AND post_zones.tax_code_id=tax_codes.tax_code_id
			";
		$result = mysql_query ($query);
		$zone = mysql_result ($result, 0, 'zone');
		$tax_code = mysql_result ($result, 0, 'tax_code');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this zone will orphan all the zones countrie and post costs belonging to this zone</span></td></tr>
		<tr><td align="right"><b>Zone</b></td><td><?=$zone?></td></tr>
		<tr><td align="right"><b>Tax Code</b></td><td><?=$tax_code?></td></tr>
		<input type="hidden" name="pzid" value="<?=$_GET['pzid']?>" />
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