<?php // add_news.php (administration side) Friday, 8 April 2005
// This is the add News page for the admin side of the site.

// Set the page title.
$page_title = "Add News";

$custom_headtags = '
<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/admin/js/tinymce_init.js"></script>
<!-- /TinyMCE -->
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');


// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else { 

	$link1 = explode ('/', $https);
	$link2 = explode ('/', $merchant_website);

	print "<p><a href=\"index.php\">Back to Overview</a></p>";
    
	if (isset ($_POST['entry'])) { // Handle the form.
		
		$data = escape_data($_POST['entry']);
	
		if ( $link1[(count($link1) - 1)] != $link2[(count($link2) - 1)]) {
			
			$data = str_replace("src=\"/{$link1[(count($link1) - 1)]}", "src=\"..", $data);
		} else {
			
			$data = str_replace("src=\"", "src=\"..", $data);
		}
		
		
		// Define the query.
		$query = "INSERT INTO news_blog (title, entry, date_entered) VALUES ('{$_POST['title']}', '{$data}', NOW())";
		print "<div align=\"center\">";
		// Execute the query.
		if (mysql_query ($query)) {
			print ("<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" />The NEWS entry has been added.</p></span><p align=\"center\"><a href=\"view_news.php\" class=\"view\" ><img src=\"/admin/images/view.png\" style=\"border:0px;\"/>View News</a></p>");
		} else {
			echo "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Could not add the entry because: <b>" . mysql_error() . "</b>. The query was " . $query . ".</p></span><p align=\"center\"><a href=\"view_news.php\" class=\"view\" ><img src=\"/admin/images/view.png\" style=\"border:0px;\"/>View News</a></p>";
		}
		print "</div>";
		mysql_close(); // Close the database.
		
	} else { // Display the form.
	 	
		?>
		<div class="center">
		<form action="add_news.php" method="post">
		<b>Entry Title:</b><input type="text" name="title" size="40" />
		<textarea name="entry"></textarea>
		</form>
		</div>
		<?php
	} // End of form.	
	
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>