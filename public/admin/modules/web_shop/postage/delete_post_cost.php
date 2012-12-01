<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Post Level";

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
		
            Utility::go ('post_costs.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$pcid = $_POST['pcid'];
			
			$query = "
					DELETE FROM post_cost
					WHERE post_cost_id=$pcid
					";
			
			$result = mysql_query ($query);
				
            Utility::go ('post_costs.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT post_level, zone, cost
			FROM post_cost, post_level, post_zones
			WHERE post_cost_id={$_GET['pcid']}
			AND post_cost.post_level_id=post_level.post_level_id
			AND post_cost.post_zone_id=post_zones.post_zone_id
			";
		$result = mysql_query ($query);
		
		$post_level = mysql_result ($result, 0, 'post_level');
		$zone = mysql_result ($result, 0, 'zone');
		$cost= mysql_result ($result, 0, 'cost');
		
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Are you sure you want to delete this Post Cost?</span></td></tr>
		<tr><td align="right"><b>Post Cost</b></td><td><?=$cost?></td></tr>
		<tr><td align="right"><b>Post Level</b></td><td><?=$post_level?></td></tr>
		<tr><td align="right"><b>Post Zone</b></td><td><?=$zone?></td></tr>
		<input type="hidden" name="pcid" value="<?=$_GET['pcid']?>" />
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