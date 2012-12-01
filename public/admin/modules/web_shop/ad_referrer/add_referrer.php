<?php 
// view_order.php Tuesday, 3 May 2005
// This is the add catagory page for admin.
	  
// Set the page title.
$page_title = "Add Advert";
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
		if ($_POST['submit'] == "Add Advert") {
						  
			$error = NULL;
								  
			if (isset ($_POST['referrer'])) {
				
				$referrer = escape_data (trim (ucwords($_POST['referrer'])));
				
			} else {
				$referrer = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a advert<span></p>";
			}
												  
			// If all is well.
			if ($referrer) {
												  
				// Check if tax code is availiable.
				$query = "
					SELECT ad_referrer
					FROM ad_referrer
					WHERE ad_referrer='$referrer'
				";
				
				$result = mysql_query ($query);
												  
				if (mysql_num_rows($result) == 0) {
												  
					// Add Tax code.
					$query = "
						INSERT INTO ad_referrer (ad_referrer)
						VALUES ('$referrer')
					";
					$result = mysql_query ($query);
					
                    Utility::go ('index.php');
												  
				} else {
					print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This tax rate already exists<span></p>";
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
																	  
					<tr><td align="right"><b>Advert</b></td><td><input type="text" name="referrer" value="" maxlength="100" size="30" /></td></tr>
																	
					<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Advert" /></td></tr>
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