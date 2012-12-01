<?php // view_order.php Tuesday, 3 May 2005
// This is the edit catagory page for admin.

// Set the page title.
$page_title = "Edit Post Level";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/webshop_config.php');

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
		if ($_POST['submit'] == "Change") {
			
			$pcid = $_POST['pcid'];
			
			if (is_numeric ($_POST['cost'])) {
				$cost = escape_data ($_POST['cost']);
			} else {
				$cost = FALSE;
				$error = "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a post cost<span></p>";
			}
			
			
			if (is_numeric ($_POST['vat_inc'])) {
				$vat_inc = escape_data ($_POST['vat_inc']);	
			} else {
				$vat_inc = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please choose a vat state<span></p>";
			}
			
			if (is_numeric ($_POST['post_level'])) {
				$post_level = escape_data ($_POST['post_level']);	
			} else {
				$post_level = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please choose a post level<span></p>";
			}
			
			if (is_numeric ($_POST['post_zone'])) {
				$post_zone = escape_data ($_POST['post_zone']);	
			} else {
				$post_zone = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please choose a post zone<span></p>";
			}
			
			// If all is well.
			if ($cost && $vat_inc && $post_level && $post_zone) {
				
				// Check if availiable.
				$query = "
					SELECT post_cost_id
					FROM post_cost
					WHERE cost=$cost
					AND post_level_id=$post_level
					AND post_zone_id=$post_zone
					AND post_cost_id != $pcid
					";
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Post Level.
					$query = "
						UPDATE post_cost 
						SET post_level_id=$post_level, post_zone_id=$post_zone, cost=$cost, vat_inc=$vat_inc
						WHERE post_cost_id=$pcid
						";
					//print $query;
					$result = mysql_query ($query);
			
                    Utility::go ('post_costs.php');
} else { 
					 print "<p class=\"fail\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This Post Cost already exists<span></p>";
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
   		
		$query = "
			SELECT post_cost_id, post_level_id, post_zone_id, cost, vat_inc
			FROM post_cost
			WHERE post_cost_id={$_GET['pcid']}
			";
		$result = mysql_query ($query);
		$post_cost_id = mysql_result ($result, 0, 'post_cost_id');
		$post_level_id = mysql_result ($result, 0, 'post_level_id');
		$post_zone_id = mysql_result ($result, 0, 'post_zone_id');
		$cost= mysql_result ($result, 0, 'cost');
		$vat_inc = mysql_result ($result, 0, 'vat_inc');
		
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		
		<tr><td align="right"><b>Post Cost</b></td><td><input type="text" name="cost" value="<?=$cost;?>" maxlength="10" size="10" />
		<?php
		
		if ($VatState == 1) {
			
			print "<b>Including Tax:</b> <input type=\"radio\" name=\"vat_inc\" value=\"1\"";
			if ($vat_inc == 1) print " checked=\"checked\"";
			print "/>";
			print "<b>Excluding Tax:</b> <input type=\"radio\" name=\"vat_inc\" value=\"0\"";
			if ($vat_inc == 0) print " checked=\"checked\"";
			print "/>";
			
		
		} else {
			echo "<input type=\"hidden\" name=\"vat_inc\" value=\"1\" />";
		}
		?></td></tr>
		
		<tr><td align="right"><b>Post Level:</b></td><td align="left"><select name="post_level"><option>Select One</option>
		<?php
		// Retrieve all the post levels and add to the pull down menu.
		$query = "
			SELECT * 
			FROM post_level
			";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			print "<option value=\"{$row['post_level_id']}\"";
			if ($post_level_id == $row['post_level_id']) print " selected=\"selected\"";
			print ">{$row['post_level']}</option>";
		}
		?>
		</select></td></tr>
		
		<tr><td align="right"><b>Zone:</b></td><td align="left"><select name="post_zone"><option>Select One</option>
		<?php
		// Retrieve all the post zones and add to the pull down menu.
		$query = "
			SELECT *
			FROM post_zones
			";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			print "<option value=\"{$row['post_zone_id']}\"";
			if ($post_zone_id == $row['post_zone_id']) print " selected=\"selected\"";
			print ">{$row['zone']}</option>";
		}
		?>
		</select></td></tr>
		<input type="hidden" name="pcid" value="<?=$_GET['pcid']?>" />
		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Change" /></td></tr>
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