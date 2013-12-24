<?php // page_content_overview.php (administration side) Friday, 8 April 2005

// Set the page title.
$page_title = "Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	// Create site map from menu links in database.
	new SiteMap();
	
	print "<div style=\"text-align:center;\">";
	print '<h1><a href="index.php">Click To return to page overview</a></h1>';
	print '<p>Your update to sitemap.xml has been successful.</p>';
	print '</div>';
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
