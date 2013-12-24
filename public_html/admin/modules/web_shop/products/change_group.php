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
			
			$error = NULL;
			$pid = $_POST['pid'];
			
			if (is_numeric ($_POST['group'])) {
				$group = escape_data ($_POST['group']);	
			} else {
				$group = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a price<span></p>";
			}
			
			// If all is well.
			if (is_numeric($group)) {
				// Get group price.
				if ($group > 0) {
					$query = "
						SELECT price
						FROM product_group_price
						WHERE group_id=$group
						";
					$result = mysql_query ($query);
					$price = mysql_result ($result, 0, 'price');
					
					// Update product
					$query = "
						UPDATE products
						SET group_id=$group, price=$price
						WHERE product_id=$pid
						";
					$result = mysql_query ($query);
					
				} else {
					// Update product id only
					$query = "
						UPDATE products
						SET group_id=$group
						WHERE product_id=$pid
						";
					$result = mysql_query ($query);
				}
				if (is_numeric ($_POST['s']) && is_numeric ($_POST['np'])) {
					$query_string = "?s={$_POST['s']}&np={$_POST['np']}";
				} else {
					$query_String = "";
				}
                Utility::go ('index.php' . $query_string);
			
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
			SELECT product_name, description, group_id
			FROM products
			WHERE product_id={$_GET['pid']}
			LIMIT 1
			";
		$result = mysql_query ($query);
		$pn = mysql_result ($result, 0, 'product_name');
		$d = mysql_result ($result, 0, 'description');
		$gid = mysql_result ($result, 0, 'group_id');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td>Which group would you like to assign <?="$pn $d";?> to?</td></tr>
		<?php
		$query = "
			SELECT group_id, product_group, price
			FROM product_group_price
			";
		$result = mysql_query ($query);
		
		print "<tr><td><input type=\"radio\" name=\"group\" value=\"0\"";
		
		if ($gid == 0) {
			print " checked=\"checked\"";
		}
		print " /> No Group</td></tr>";
		
		while ($row = mysql_fetch_array ($result, MYSQL_NUM)) {
			print "<tr><td><input type=\"radio\" name=\"group\" value=\"{$row[0]}\"";
			if ($gid == $row[0]) {
				print "checked=\"checked\"";
			}
			print " /> {$row[1]} {$row[2]}</td></tr>";
		}
		
		?>
		<input type="hidden" name="pid" value="<?=$_GET['pid'];?>" />
		<input type="hidden" name="s" value="<?=$_GET['s'];?>" />
		<input type="hidden" name="np" value="<?=$_GET['np'];?>" />
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
