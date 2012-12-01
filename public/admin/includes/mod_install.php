<?php
function module_install ($tables, $table_data, $dir, $mod_name, $menu_links) {  

	global $merchant_db_name;
	$fail = FALSE;
	$m = "";
	
	// Create tables if they don't exist.
	foreach ($tables as $table => $columns) {
		$query = "
			SHOW TABLES
			FROM $merchant_db_name
			LIKE '$table'
			";
		$result = mysql_query ($query);
		$exists = mysql_num_rows ($result);
		
		if ($exists == 0) {
			$query = "CREATE TABLE $table ($columns);";
			
			if ($result = mysql_query ($query)) {
				
				print "<p>Created $table</p>";
			} else {
				$fail = TRUE;
				$m .= "<p>failed to Create $table due to system error</p>";
			}
		} else {
			$fail = TRUE;
			$m .= "<p>failed to Create $table as it alredy exists</p>";
		}
   			
	} // End of create tables
	
	
	// Add defualt data in database tables.
	foreach ($table_data as $table => $data) {
		
		$query = "
			SHOW TABLES 
			FROM $merchant_db_name
			LIKE '$table'
			";
		$result = mysql_query ($query);
		
		if (mysql_num_rows($result) == 1) {
			
			// determine number of colums and values.
			$num_col = count ($data['columns']); 
			$num_val = count ($data['values']);
			
			// Set initial Values.
			$columns = "";
			$values ="";
			
			// assign column data.
			for ($n = 0; $n < $num_col; $n++) {
				if ($n == ($num_col - 1)) {
					$columns .= $data['columns'][$n];
				} else {
					$columns .= $data['columns'][$n] . ", ";
				}
			}
			
			// insert into database.
			for ($n = 0; $n < $num_val; $n++) {
				$query = "
					INSERT INTO $table ($columns)
					VALUES {$data['values'][$n]}
					";
				
				if ($result = mysql_query ($query)) {
					print "<p>Inserted {$data['values'][$n]} into $table</p>\r\n";
				} else {
					$fail = TRUE;
					$m .= "<p>Could not insert {$data['values'][$n]} into $table</p>\r\n";
				}
			} // End of database query.
				
		} else {
			$fail = TRUE;
			$m .= "<p>Could not insert {$data['values'][$n]}, as table $table does not exist</p>";	
		}   		
	} // End of default data.
	
	
	// Create links in the menu.
	foreach ($menu_links as $parent => $child) {
		
		// make the parents, if already made get thier id.
		$query = "
			SELECT parent_id
			FROM menu_parent
			WHERE parent='$parent'
			";
		$result = mysql_query ($query);
	
		if (mysql_num_rows ($result) == 0) {
			$query = "
				INSERT INTO menu_parent (parent)
				VALUES ('$parent')
			";
			$result = mysql_query ($query);
			$parent_id = mysql_insert_id();
			
		
		} else {
			
			$parent_id = mysql_result ($result, 0, 'parent_id');
		}
		
		
		foreach ($child as $page => $columns) {
		
			// If pages are editable and not a parent, then insert into page table and get page id.
			if ($columns['url'] != "#" && $columns['editable'] == "Y") {
	 	
				$query = "
				SELECT page_id
				FROM pages
				WHERE page='$page'
				";
				$result = mysql_query ($query);
	
				if (mysql_num_rows ($result) == 0) {
					$query = "
						INSERT INTO pages (page, date_entered)
						VALUES ('$page', NOW())
					";
					$result = mysql_query ($query);
					$page_id = mysql_insert_id();
				} else {
		
					$page_id = mysql_result ($result, 0, 'page_id');
				}
			} else {

				$page_id = 0;
			} // End of page id.
			
			// Get status id
			$query = "
				SELECT status_id
				FROM menu_link_status
				WHERE status='{$columns['status']}'
				";
			$result = mysql_query ($query);
			$columns['status'] = mysql_result ($result, 0, 'status_id');
			// End of status id.
			
			// Check to see if link is in menu.
			$query = "
			SELECT links_id
			FROM menu_links
			WHERE title='$page'
			";
			$result = mysql_query ($query);
	
			if (mysql_num_rows ($result) == 0) {
			
				// Find sort order.
				$query = "
					SELECT MAX(sort_order)
					FROM menu_links
					WHERE parent_id=$parent_id
					";
				$result = mysql_query ($query);
				$max_place = mysql_result($result,0,"max(sort_order)");
				$sort_order = $max_place + 1;
			
				$query = "
					INSERT INTO menu_links (page_id, parent_id, modified_date, sort_order, title, status_id, editable, deletable, in_menu, hits, url)
					VALUES ($page_id, $parent_id, NOW(), $sort_order, '$page', {$columns['status']}, '{$columns['editable']}', '{$columns['deletable']}', '{$columns['in_menu']}', 0, '{$columns['url']}')
				";
				$result = mysql_query ($query);
			
			} else {
				$m .= "<p>page $page already exists</p>";
				$fail = TRUE;
			}// End of query.
		}
	} // End links menu.
	
	
	// Copy the user directories.
	foreach ($dir as $directory => $destination) {
		if ($directory == "config") {
			$root = $_SERVER['DOCUMENT_ROOT'] . "/../";
		} else {
			$root = $_SERVER['DOCUMENT_ROOT'] . "/";
		}
		copyr ($destination, $root . $destination);
	}
	
	if ($fail == FALSE) {
		// Add module to database. 									   
		$query = "
			INSERT INTO modules (module, version)
			VALUES ('{$mod_name['name']}', '{$mod_name['version']}')
			";
		$result = mysql_query ($query);
	} else {
		print "<p style=\"color:red;font-size:18pt\">Module FAILED</p>";
		echo $m;
	}
	
}  // end of module install.
?>