<?php 
// view_order.php Tuesday, 3 May 2005
// This is the add catagory page for admin.
	  
// Set the page title.
$page_title = "Edit Advert";
	  
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
		if ($_POST['submit'] == "Update Advert") {
			
			$error = NULL;
						  
			if ($_POST['referrer']) {
				$referrer = escape_data (trim (ucwords($_POST['referrer'])));
			} else {
				$referrer = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a Advert<span></p>";
			}
			
			// If all is well.
			if ($referrer) {
				
				$query = "
					UPDATE ad_referrer 
					SET ad_referrer='$referrer'
					WHERE ad_referrer_id={$_POST['arid']}
				";
				$result = mysql_query ($query);
					
                Utility::go ('index.php');
								  
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
			SELECT ad_referrer_id, ad_referrer
			FROM ad_referrer
			WHERE ad_referrer_id={$_GET['arid']}
		";
		$result = mysql_query ($query);
		$ad_referrer_id = mysql_result ($result, 0, 'ad_referrer_id');
		$ad_referrer = mysql_result ($result, 0, 'ad_referrer');
											   
		?>
		<div class="box">
			<table cellspacing="2" cellpadding="2">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
													  
					<tr><td align="right"><b>Adverts</b></td><td><input type="text" name="referrer" value="<?=$ad_referrer;?>" maxlength="100" size="30" /></td></tr>
													  
					<tr><td colspan="2" align="center">
					<input type="hidden" name="arid" value="<?=$ad_referrer_id;?>" />
					<input type="submit" name="submit" value="Update Advert" />
					</td></tr>
					
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