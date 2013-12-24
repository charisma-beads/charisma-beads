<?php // view_order.php Tuesday, 3 May 2005
// This is the add post level page for admin.

// Set the page title.
$page_title = "Add Post Zone";

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
		if ($_POST['submit'] == "Add Post Zone") {
			
			
			if (isset ($_POST['post_zone'])) {
				$post_zone = escape_data ($_POST['post_zone']);	
			} else {
				$post_zone = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a post zone<span></p>";
			}
			
			if (isset ($_POST['tax_code_id'])) {
				$tax_code_id = escape_data ($_POST['tax_code_id']);	
			} else {
				$tax_code_id = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a tax code<span></p>";
			}
			
			// If all is well.
			if ($post_zone && $tax_code_id) {
				
				// Check if availiable.
				$query = "
					SELECT post_zone_id
					FROM post_zones
					WHERE zone='$post_zone'
					";
					
				
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Post Level.
					$query = "
						INSERT INTO post_zones (zone, tax_code_id)
						VALUES ('$post_zone', $tax_code_id)
						";
					print $query;
					$result = mysql_query ($query);
					
                    Utility::go ('index.php');
				} else {
					 print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This zone already exists<span></p>";
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
		
		<tr><td align="right"><b>Post Zone</b></td><td><input type="text" name="post_zone" value="" maxlength="30" size="30" /></td></tr>
		
		<tr><td align="right"><b>Tax Code</b></td><td>
		<select name="tax_code_id"><option>Select One</option>
		<?php // Retrieve all the tax codes and add to the pull down menu.
		$query = "SELECT tax_code_id, tax_code, description, tax_rate FROM tax_codes, tax_rates WHERE tax_codes.tax_rate_id=tax_rates.tax_rate_id";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			if ($row['tax_rate'] > 0) {
				$row['tax_rate'] = substr ($row['tax_rate'], 2);
				$row['tax_rate'] = substr ($row['tax_rate'], 0, 2) . "." . substr ($row['tax_rate'], -1);
				if (substr ($row['tax_rate'], 0, 1) == 0) {
					$row['tax_rate'] = substr ($row['tax_rate'], 1);
				}
			
				$row['tax_rate'] = number_format ($row['tax_rate'], 2);
			
			} else {
				$row['tax_rate'] = number_format ($row['tax_rate'], 2);
			}
		
			echo "<option value=\"{$row['tax_code_id']}\">{$row['tax_code']} - {$row['description']} - {$row['tax_rate']}%</option>\r\n";
		}
		?>
		</select>
		</td></tr>
		
		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Post Zone" /></td></tr>
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