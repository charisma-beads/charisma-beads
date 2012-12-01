<?php // page_content_overview.php (administration side) Friday, 8 April 2005
// This is the page content overview page for the admin side of the site.

// Set the page title.
$page_title = "Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 

	print "<p><a href=\"index.php\">Back to Overview</a></p>";
	// Delete page.
	$query = "
		SELECT url, page_id, sort_order, parent_id
		FROM menu_links
		WHERE links_id={$_GET['lid']}
		LIMIT 1;
		";
	$result = mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_NUM);
	
	/*
	$file = $_SERVER['DOCUMENT_ROOT'] . '/' . $row[0];
	if (file_exists ($file)) {
		unlink ($file);
	}
	*/
	
	// Update Sort Order.
	$query = "
		UPDATE menu_links
		SET sort_order=sort_order-1
		WHERE parent_id={$row[3]}
		AND sort_order>{$row[2]}
		";
	$result = mysql_query ($query);
	
	// Delete page form pages database.
	if ($row[1] > 0) {
		$query = "
			DELETE FROM pages
			WHERE page_id={$row[1]}
			LIMIT 1;
			";
		$result = mysql_query ($query);
	}
	
	// Delete page form the menu.
	$query = "
		DELETE FROM menu_links
		WHERE links_id={$_GET['lid']}
		LIMIT 1;
		";
	$result = mysql_query ($query);
	
	if (mysql_affected_rows () == 1) {
		ob_end_clean ();
		header ("Location: $https/admin/modules/pages/index.php");
		exit ();
	} else {
		print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Sorry I can not delete this page. Please try again.</p></span>";
	}
		
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>