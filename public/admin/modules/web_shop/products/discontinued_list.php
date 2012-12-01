<?php // view_order.php Tuesday, 3 May 2005
// This is the products page for admin.

// Set the page title.
$page_title = "Products";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);
	
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	print "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">";
	print "Product filter<br />";
	if (isset($_POST['pcf']) && is_numeric($_POST['pcf'])) {
		$selected = "selected=\"selceted\"";
	}
	?>
	<select name="pcf" onChange="this.form.submit()">
		<option style="font-weight:bold">Select One</option>
		
		<?php // Retrieve all the product lines and add to the pull down menu.
		
		print "<option value=\"0\"";
		if (isset($_POST['pcf']) && $_POST['pcf'] == 0) print " $selected";
		print ">All Categories</option>";
	
		foreach ($tree->getTree() as $row) {
			print "<option value=\"{$row['category_id']}\"";
			if (isset($_POST['pcf']) && $_POST['pcf'] == $row['category_id']) print " $selected";
			print ">".str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth']));
			if ($row['depth'] > 0) print "&bull;&nbsp;";
			print "{$row['category']}</option>\r\n";
		}
		?>
	</select>
	<?php
	print "</form>";
	
	if (isset ($_POST['pcf'])) {
		if ($_POST['pcf'] > 0 && is_numeric ($_POST['pcf'])) {
			$tree->setId($_POST['pcf']);
			$decendants = $tree->getDecendants();
			
			$search_categories = NULL;
	
			foreach ($decendants AS $key => $value) {
				$search_categories .= $decendants[$key]['category_id'] . ',';
			}
	
			$search_categories = substr ($search_categories, 0, -1);
			
			$_SESSION['filter'] = $search_categories;
		} else {
			if (isset ($_SESSION['filter'])) {
				unset ($_SESSION['filter']);
			}
		}
	}
	
	require_once ('menu_links.php');
	
	print "<table class=\"todo_menu\">";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"add_product.php\" class=\"Link\">Add New Product</a></td></tr>";
	
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"out_of_stock.php\" class=\"Link\" >Export Out of Stock List</a></td></tr>";
	
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"catelogue.php\" class=\"Link\">Export Product List</a></td></tr>";
	
	print "</table>";	
		
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";
    
    // Number of records to show.
    $display = 50;
	
	// Change the Product Status.
	if (isset ($_GET['status'])) {
		if ($_GET['status'] == 1) {
			$change_status = 1;
		} else {
			$change_status = 0;
		}
		
		$query = "
			UPDATE products
			SET discontinued=$change_status
			WHERE product_id={$_GET['pid']}
			";
		$result = mysql_query ($query);
	}
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.
        $query = "SELECT product_id FROM products WHERE discontinued=1 ";
		if (isset ($_SESSION['filter'])) {
	 		$query .= "AND category_id IN ({$_SESSION['filter']}) ";
		} // Standard query
        $query_result = mysql_query ($query);
        $num_records = mysql_num_rows ($query_result);
        
        if ($num_records > $display) { // More than 1 page.
            $num_pages = ceil ($num_records/$display);
        } else {
            $num_pages = 1;
        }
    }
    
    // Determine where in the database to start returning results.
    if (isset($_GET['s'])) { // Already been determined.
        $start = $_GET['s'];
    } else {
        $start = 0;
    }
	
	
    
    // Make the query.
    $query = "
		SELECT product_id, group_id, product_name, price, short_description, products.image, enabled, products.category_id, lft
		FROM products, product_category
		WHERE discontinued=1
		AND products.category_id=product_category.category_id
		";
	if (isset ($_SESSION['filter'])) {
	 	$query .= "AND products.category_id IN ({$_SESSION['filter']}) ";
	} 
	$query .= "
		ORDER BY lft ASC, product_name ASC
		LIMIT $start, $display";
	
    $result = mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
	
    if ($num > 0) { // If it ran OK, display the records.

        echo "<br />";
		
		print "<div class=\"box\">";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
		
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="discontinued_list.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="discontinued_list.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="discontinued_list.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p>';

        } // End of links section.
	   	
        // Table header.
        echo '<table align="center" cellspacing="2" cellpadding="2">
        <tr bgcolor="#EEEEEE"><th>&nbsp;</th><th>Name</th><th>Description</th><th>Price</th><th>Picture</th><th>Group</th><th>&nbsp;</th><th>&nbsp;</th></tr>';

        // Fetch and print all the records.
        $bg = 'EEEEEE'; // Set the background colour.
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
			
			// Set Status of Product.
			
			$status = "<a href=\"{$_SERVER['PHP_SELF']}?status=0&pid={$row['product_id']}";
			if (isset ($_GET['s']) && isset ($_GET['np'])) {
				$status .= "&s={$_GET['s']}&np={$_GET['np']}";
			}
			$status .= "\" >Reinstate</a>";
			
			// Set picture status.
			$product_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/images/";
			//$category = NULL;
			//foreach ($tree->pathway($row['category_id']) as $id => $path) {

				//$category .= "/" . strtolower (str_replace (" ", "_", str_replace ("/", "_",$path['category'])));

			//}

			//$img_dir = $product_img_dir . $category;
			$line_img = $product_img_dir.$row['image'];
			
			if (file_exists($line_img)) {
				$img_file = "<img src=\"/admin/images/actionok.png\" alt=\"Image file present\"/>";
			} else {
				$img_file = "<img src=\"/admin/images/actionno.png\" alt=\"Image file missing\" />";
			}
			
			// Get the group codes.
			if ($row['group_id'] > 0) {
				$q = "SELECT product_group FROM product_group_price WHERE group_id={$row['group_id']}";
				$r = mysql_query ($q);
				$group_code =  mysql_result ($r, 0, 'product_group');
			} else {
				$group_code = "-";
			}
			
            $bg = ($bg=='EEEEEE' ? 'FFFFFF' : 'EEEEEE'); // Switch the background colour.
			
            print "<tr bgcolor=\"#$bg\">\n";
			print "<td>$status</td>\n";
			print "<td align=\"left\">{$row['product_name']}</td>\n";
			print "<td align=\"left\">{$row['short_description']}</td>\n";
			print "<td align=\"left\">&pound;{$row['price']}</td>\n";
			print "<td align=\"center\">$img_file</td>\n";
			print "<td align=\"center\"><a href=\"change_group.php?pid={$row['product_id']}&{$_SERVER['QUERY_STRING']}\" /><img src=\"image.php?bg=$bg&txt=$group_code\" /></a></td>\n";
			
			if (isset ($_GET['s']) && isset ($_GET['np'])) {
				$page_num = "&s={$_GET['s']}&np={$_GET['np']}";
			} else {
				$page_num = NULL;
			}
			
			print "<td align=\"center\"><a href=\"edit_product.php?pid={$row['product_id']}$page_num\" /><img src=\"/admin/images/edit.png\" alt=\"Edit Product details\"/></a></td>\n";
			
			print "<td align=\"center\"><a href=\"delete_product.php?pid={$row['product_id']}\" /><img src=\"/admin/images/delete.png\" alt=\"delete Product\"/></a></td>\n";
			print "</tr>\n";
        }

        echo '</table>'; // Close the table.

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="discontinued_list.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="discontinued_list.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="discontinued_list.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p></div>';

        } // End of links section.
		
		print "</td></tr></table>";
        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
		
        echo '<h3>There are currently no products.</h3>';
		print "</td></tr></table>";
    }
	
	mysql_close(); // Close the database connection.

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>