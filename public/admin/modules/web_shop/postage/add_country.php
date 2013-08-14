<?php // view_order.php Tuesday, 3 May 2005
// This is the add post level page for admin.

// Set the page title.
$page_title = "Add Country";

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
		if ($_POST['submit'] == "Add Country") {
			
			
			if (isset ($_POST['country'])) {
				$country = escape_data (ucwords ($_POST['country']));	
			} else {
				$country = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a country<span></p>";
			}
			
			if (isset ($_POST['post_zone_id'])) {
				$post_zone_id = escape_data ($_POST['post_zone_id']);	
			} else {
				$post_zone_id = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a post zone<span></p>";
			}
			
			// If all is well.
			if ($post_zone_id && $country) {
				
				// Check if availiable.
				$query = "
					SELECT country_id
					FROM countries
					WHERE country='$country'
					";
					
				
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Post Level.
					$query = "
						INSERT INTO countries (country, post_zone_id)
						VALUES ('$country', $post_zone_id)
						";
					
					$result = mysql_query ($query);
					
                    Utility::go ('countries.php');
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
		
		<tr><td align="right"><b>Country</b></td><td><input type="text" name="country" value="" maxlength="30" size="30" /></td></tr>
		
		<tr><td align="right"><b>Zone:</b></td><td align="left"><select name="post_zone_id"><option>Select One</option>
		<?php
		// Retrieve all the post zones and add to the pull down menu.
		$query = "
			SELECT post_zone_id, zone 
			FROM post_zones
			";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			print "<option value=\"{$row['post_zone_id']}\">{$row['zone']}</option>";
}
		?>
		</select></td></tr>
		
		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Country" /></td></tr>
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