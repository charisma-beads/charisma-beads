<?php // view_order.php Tuesday, 3 May 2005
// This is the add post level page for admin.

// Set the page title.
$page_title = "Add Post Level";

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
		if ($_POST['submit'] == "Add Post Level") {
			
			
			if (is_numeric ($_POST['post_level'])) {
				$post_level = escape_data ($_POST['post_level']);	
			} else {
				$post_level = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a post level<span></p>";
			}
			
			// If all is well.
			if ($post_level) {
				
				// Check if availiable.
				$query = "
					SELECT post_level_id
					FROM post_level
					WHERE post_level=$post_level
					";
				$result = mysql_query ($query);
				
				if (mysql_num_rows($result) == 0) {
				
					// Add Post Level.
					$query = "
						INSERT INTO post_level (post_level)
						VALUES ($post_level)
						";
					//print $query;
					$result = mysql_query ($query);
			
                    Utility::go ('post_level.php');
				} else {
					 print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This post level already exists<span></p>";
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
		
		<tr><td align="right"><b>Post Level</b></td><td><input type="text" name="post_level" value="" maxlength="10" size="5" /></td></tr>
		
		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Post Level" /></td></tr>
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