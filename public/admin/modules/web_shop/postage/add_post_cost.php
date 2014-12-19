<?php // view_order.php Tuesday, 3 May 2005
// This is the add Post Cost page for admin.

// Set the page title.
$page_title = "Add Post Cost";

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
		if ($_POST['submit'] == "Add Post Cost") {
			
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
					";
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Post Level.
					$query = "
						INSERT INTO post_cost (post_level_id, post_zone_id, cost, vat_inc)
						VALUES ($post_level, $post_zone, $cost, $vat_inc)
						";
					print $query;
					$result = mysql_query ($query);
			
                    Utility::go ('post_costs.php');
				} else { 
					 print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This Post Cost already exists<span></p>";
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
		
		<tr><td align="right"><b>Post Cost</b></td><td><input type="text" name="cost" value="" maxlength="10" size="5" />
		<?php
		if ($VatState == 1) {
		?>	
		<b>Including Tax:</b> <input type="radio" name="vat_inc" value="1" />
		<b>Excluding Tax:</b> <input type="radio" name="vat_inc" value="0" />
		<?php
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
			print "<option value=\"{$row['post_level_id']}\">{$row['post_level']}</option>";
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
			print "<option value=\"{$row['post_zone_id']}\">{$row['zone']}</option>";
		}
		?>
		</select></td></tr>

		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Post Cost" /></td></tr>
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