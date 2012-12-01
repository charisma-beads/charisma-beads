<?php // delete_entry.php (administration side) 14 May 2005
// This is the edit news page for the admin side of the site.

// Set the page title.
$page_title = "Edit News";

$custom_headtags = '
<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/admin/js/tinymce_init.js"></script>
<!-- /TinyMCE -->
		';
// Include configuration file for error management and such. 

include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Require authentication

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else {

	print "<p><a href=\"index.php\">Back to Overview</a></p>";
	
	$link1 = explode ('/', $https);
	$link2 = explode ('/', $merchant_website);
    
	if (isset ($_POST['id'])) { // Handle the form.
		
		$data = escape_data($_POST['entry']);
	
		if ( $link1[(count($link1) - 1)] != $link2[(count($link2) - 1)]) {
			
			$data = str_replace("src=\"/{$link1[(count($link1) - 1)]}", "src=\"..", $data);
		} else {
			
			$data = str_replace("src=\"", "src=\"..", $data);
		}
		
		// Define the query.
		$query = "UPDATE news_blog SET title='{$_POST['title']}', entry='{$data}' WHERE blog_id='{$_POST['id']}'";
		$result = mysql_query ($query); // Execute the query.
		
		// Report the result.
		print "<div align=\"center\">";
		if (mysql_affected_rows() == 1) {
			print ("<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" />The NEWS entry has been updated.</p></span><p align=\"center\">");
		} else {
			echo "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Could not update the entry because: <b>" . mysql_error() . "</b>. The query was " . $query . ".</p></span>";
		}
		print "<p align=\"center\"><a href=\"view_news.php\" class=\"view\" ><img src=\"/admin/images/view.png\" style=\"border:0px;\"/>View News</a></p>";
		print "</div>";
		
		
	} else { // Display the form.
	
		// Check for a valid ID in the form.
		if (is_numeric ($_GET['id'])) {
			
			// Define the query.
			$query = "SELECT * FROM news_blog WHERE blog_id={$_GET['id']}";
			if ($result = mysql_query ($query)) { // Run the query.
			
				$row = mysql_fetch_array ($result); // Retrieve the information.
	 	
				?>
				<div class="center">
				<form action="edit_entry.php" method="post">
				<b>Entry Title:</b><input type="text" name="title" size="40" value="<?php print $row['title']; ?>" />
				<textarea name="entry"><?=$row['entry'];?></textarea>
				<input type="hidden" name="id" value="<?php print $_GET['id']; ?>" />
				</form>
				</div>
				<?php
				
			} else { // Couldn't get the information.
				print "<div><span class=\"smcap\" ><p class=\"fail\" align=\"center\"><img src=\"/admin/images/actionno.png\" />Could not retrieve the entry because: <b>" . mysql_error() . "</b>. The query was $query.</p></span></div>";
			}
			
		} else { // No ID set.
			print '<p><b>You must of made a mistake using this page.</b></p>';
		}
		
	} // End of IF.
	
	mysql_close(); // Close the database connection.
		
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>