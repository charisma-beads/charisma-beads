<?php 
// view_order.php Tuesday, 3 May 2005
// This is the delete group page for admin.

// Set the page title.
$page_title = "Delete Group";

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
		
            Utility::go ('group_price.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$gid = $_POST['gid'];
			
			$query = "
					DELETE FROM product_group_price
					WHERE group_id=$gid
					";
			//print $query;
			$result = mysql_query ($query);
			// Update prices.
			$query = "
					UPDATE products
					SET group_id=0
					WHERE group_id=$gid
					";
			//print $query;
			$result = mysql_query ($query);
				
            Utility::go ('group_price.php');
			
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
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this group will set all the prices that belonged to this group</span></td></tr>
		<tr><td align="right"><b>Group</b></td><td><?=$group?></td></tr>
		<tr><td align="right"><b>Price</b></td><td><?=$price?></td></tr>
		<input type="hidden" name="gid" value="<?=$_GET['gid']?>" />
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