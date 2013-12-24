<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Advert";

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
		
            Utility::go ('index.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$arid = $_POST['arid'];
			
			$query = "
				DELETE FROM ad_referrer
				WHERE ad_referrer_id=$arid
			";
			//print $query;
			$result = mysql_query ($query);
			
			// Update ad_referrer_hits.
			$query = "
				DELETE FROM ad_referrer_hits
				WHERE ad_referrer_id=$arid
			";
			//print $query;
			$result = mysql_query ($query);
				
			go ('index.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT ad_referrer_id, ad_referrer
			FROM ad_referrer
			WHERE ad_referrer_id={$_GET['arid']}
		";
		$result = mysql_query ($query);
		$ad_id = mysql_result ($result, 0, 'ad_referrer_id');
		$ad = mysql_result ($result, 0, 'ad_referrer');
		
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this Advert will delete all its history as well</span></td></tr>
		<tr><td align="right"><b>Advert</b></td><td><?=$ad?></td></tr>
		<input type="hidden" name="arid" value="<?=$ad_id?>" />
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