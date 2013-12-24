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
		SELECT url, page_id, sort_order, parent_id, sub_menu, title
		FROM menu_links
		WHERE links_id={$_GET['lid']}
		LIMIT 1;
		";
	$result = mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_NUM);
	
	// Update Sort Order.
	$query = "
		UPDATE menu_links
		SET sort_order=sort_order-1
		WHERE parent_id={$row[3]}
		AND sort_order>{$row[2]}
		";
	$result = mysql_query ($query);
	
	// Delete page form the menu.
	$query = "
		DELETE FROM menu_links
		WHERE links_id={$_GET['lid']}
		LIMIT 1;
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
	
	// if submenu move children up one level and delete parent
	if ($row[4] == 1) {
		$query = "
            SELECT parent_id
            FROM menu_parent
            WHERE parent = '".escape_data($row[5])."'
        ";
		$result = mysql_query($query);
		
		$parentId = mysql_result($result,0,"parent_id");
		
		$query = "
            SELECT *
            FROM menu_links
            WHERE parent_id = '{$parentId}'
        ";
		$subresult = mysql_query($query);
		
		while ($resultSet = mysql_fetch_array($subresult, MYSQL_ASSOC)) {
			$query="
			SELECT MAX(sort_order)
			FROM menu_links
			WHERE parent_id={$row[3]}
			";
			$result = mysql_query($query);
			
			$max_place = mysql_result($result,0,"max(sort_order)");
	 		$max_place = $max_place + 1;
	 		
	 		$query = "
	 		UPDATE menu_links
	 		SET parent_id={$row[3]}, sort_order=$max_place,  modified_date=NOW()
	 		WHERE links_id={$resultSet['links_id']}
	 		";
			$result = mysql_query ($query);
		}
		
		$query = "
			DELETE FROM menu_parent
			WHERE parent_id={$parentId}
			LIMIT 1;
		";
		$result = mysql_query ($query);
	}
	
	if (mysql_affected_rows () == 1) {
		// Create site map from menu links in database.
		new SiteMap();
		
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