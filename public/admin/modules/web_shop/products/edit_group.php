<?php // view_order.php Tuesday, 3 May 2005
// This is the group prices page for admin.

// Set the page title.
$page_title = "Edit Group Price";

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
		if ($_POST['submit'] == "Change") {
			
			$gid = $_POST['gid'];
			
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
				// Update Group.
				$query = "
					UPDATE product_group_price
					SET product_group='$group', price=$price
					WHERE group_id=$gid
					";
				//print $query;
				$result = mysql_query ($query);
				// Update prices.
				$query = "
					UPDATE products
					SET price=$price
					WHERE group_id=$gid
					";
				//print $query;
				$result = mysql_query ($query);
				
                Utility::go ('group_price.php');
			
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
			SELECT product_group, price
			FROM product_group_price
			WHERE group_id={$_GET['gid']}
			";
		$result = mysql_query ($query);
		$group = mysql_result ($result, 0, 'product_group');
		$price = mysql_result ($result, 0, 'price');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;">Changing this will change all the prices in this group</span></td></tr>
		<tr><td align="right"><b>Group</b></td><td><input type="text" name="product_group" value="<?=$group?>" maxlength="10" size="5" /></td></tr>
		<tr><td align="right"><b>Price</b></td><td><input type="text" name="price" value="<?=$price?>" maxlength="10" size="5" /></td></tr>
		<input type="hidden" name="gid" value="<?=$_GET['gid']?>" />
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