<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Country";

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
		
            Utility::go ('countries.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$cid = $_POST['cid'];
			
			$query = "
					DELETE FROM countries
					WHERE country_id=$cid
					";
			
			$result = mysql_query ($query);
				
            Utility::go ('countries.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT zone, country
			FROM post_zones, countries
			WHERE country_id={$_GET['cid']}
			AND countries.post_zone_id=post_zones.post_zone_id
			";
		$result = mysql_query ($query);
		$zone = mysql_result ($result, 0, 'zone');
		$country = mysql_result ($result, 0, 'country');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Are you sure you want to delete this country?</span></td></tr>
		<tr><td align="right"><b>Country</b></td><td><?=$country?></td></tr>
		<tr><td align="right"><b>Zone</b></td><td><?=$zone?></td></tr>
		<input type="hidden" name="cid" value="<?=$_GET['cid']?>" />
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