<?php // page_content_overview.php (administration side) Friday, 8 April 2005
// This is the view content page for the admin side of the site.

// Set the page title.
$page_title = "View Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
		 
	$page = $_GET['page'];
	$page = explode ('/', $page);
	
		
	print '<SCRIPT language="JavaScript">';

	print 'window.location="' . $merchant_website . $page . '"';

	print '</SCRIPT>';
   	

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>