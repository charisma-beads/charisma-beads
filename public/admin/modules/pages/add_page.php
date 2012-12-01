<?php // page_content_overview.php (administration side) Friday, 8 April 2005
// This is the page content overview page for the admin side of the site.

// Set the page title.
$page_title = "Add Page";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 

	print "<p><a href=\"index.php\">Back to Overview</a></p>";
	
	if ($_POST['submit'] == "Make Page") {
	
		// Set variables.
		$title = ucwords (strtolower (escape_data($_POST['title'])));
		$PageName = str_replace (" ", "_", strtolower (Utility::filterString(escape_data($_POST['title']))));
		$url = "pages/{$PageName}.php";
	 	
		// Check to see if page exists.
		$query = "
			SELECT page_id
			FROM pages
			WHERE page='$title'
			LIMIT 1;
			";
        $result = mysql_query($query);
		
		if (mysql_num_rows ($result) == 0) {
			
			// Add page to database.
			$query = "
				INSERT INTO pages (page, date_entered) 
				VALUES ('$title', NOW() );
				";
			$result = mysql_query ($query);
			$PageId = mysql_insert_id();
			
			// Find sort order.
			$query = "
				SELECT MAX(sort_order)
				FROM menu_links
				WHERE parent_id=1
				";
			$result = mysql_query ($query);
			$max_place = mysql_result($result,0,"max(sort_order)");
			$SortOrder = $max_place + 1;
			
			// Add page to the menu links.
			$query = "
				INSERT INTO menu_links (parent_id, status_id, page_id, title, url, sort_order, editable, modified_date, deletable)
				VALUES (1, 1, $PageId, '$title', '$url', '$SortOrder', 'Y', NOW(), 'Y');
				";
			$result = mysql_query($query);
			
			// Add page on server.
			/*
			$page = file ('template.php');
			
			$content = array ('PAGE TITLE' => $title, 'PAGE ID' => $PageId);
			
			for ($d = 0; $d < count ($page); $d++) {
				foreach ($content as $key => $value) {
					$template_name = '#### ' . $key . ' ####';
					$page[$d] = str_replace ($template_name, $value, $page[$d]);
				} 
			}
			
			if ($fp = fopen ($_SERVER['DOCUMENT_ROOT'] . '/' . $url, 'wb')) {
			
				$data = "<?php\r\n";
				
				foreach ($page as $line) {
					
					$data .= $line;
				}
				
				$data .= "?>\r\n";	
			
				fwrite ($fp, "$data");
				fclose ($fp);
			}
			*/
			print ("<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> The $title page has been added.</p></span>");
		
		} else {
		
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Sorry I can not add Page {$_POST['title']} as it already exits. Please try again.</p></span>";
		
		}
	
	
	} else {
	
		?>
		<form ation="<? print $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="text" name="title" value="" />
		<input type="submit" name="submit" value="Make Page" />
		</form>
		<?php
	}
		
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>