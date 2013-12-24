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
		
            Utility::go ('post_level.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$plid = $_POST['plid'];
			
			$query = "
					DELETE FROM post_level
					WHERE post_level_id=$plid
					";
			
			$result = mysql_query ($query);
			
			// update post costs
			$query = "
				UPDATE post_cost
				SET post_level_id = 0
				WHERE post_level_id=$plid
			";
			
			$result = mysql_query($query);
				
            Utility::go ('post_level.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT post_level_id, post_level
			FROM post_level
			WHERE post_level_id={$_GET['plid']}
			";
		$result = mysql_query ($query);
		$post_level_id = mysql_result ($result, 0, 'post_level_id');
		$post_level = mysql_result ($result, 0, 'post_level');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Are you sure you want to delete this country?</span></td></tr>
		<tr><td align="right"><b>Post Level</b></td><td><?=$post_level?></td></tr>
		
		<input type="hidden" name="plid" value="<?=$_GET['plid']?>" />
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