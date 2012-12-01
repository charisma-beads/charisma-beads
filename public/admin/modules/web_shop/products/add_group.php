<?php // view_order.php Tuesday, 3 May 2005
// This is the add group page for admin.

// Set the page title.
$page_title = "Add Group";

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
		if ($_POST['submit'] == "Add Group") {
			
			if ($_POST['product_group']) {
				$group = escape_data (strtoupper ($_POST['product_group']));
			} else {
				$group = FALSE;
				$error = "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a group code<span></p>";
			}
			
			
			if (is_numeric ($_POST['price'])) {
				$price = escape_data ($_POST['price']);	
			} else {
				$price = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a price<span></p>";
			}
			
			// If all is well.
			if ($group && $price) {
				
				// Check if availiable.
				$query = "
					SELECT group_id
					FROM product_group_price
					WHERE product_group='$group'
					";
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Group.
					$query = "
						INSERT INTO product_group_price (product_group, price)
						VALUES ('$group', $price)
						";
					//print $query;
					$result = mysql_query ($query);
			
                    Utility::go ('group_price.php');
				} else {
					 print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This Group already exists<span></p>";
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
		
		<tr><td align="right"><b>Group</b></td><td><input type="text" name="product_group" value="" maxlength="10" size="5" /></td></tr>
		<tr><td align="right"><b>Price</b></td><td><input type="text" name="price" value="" maxlength="10" size="5" /></td></tr>
		
		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Group" /></td></tr>
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