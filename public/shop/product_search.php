<?php // catalogue.php Tuesday, 3 May 2005
// This is the search Catalogue page for the site.

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

// start tree class
$tree = new NestedTree('product_category', NULL, 'category', $dbc);

//globals();
$tax = 0;

if (is_numeric($_GET['search_id']) && isset ($_GET['search_query'])) {
	
	$search = $_GET['search_id'];
	
	
	//print $search;
	if ($search > 0) {
		$tree->setId($search);
		$decendants = $tree->getDecendants();
	} else {
		$decendants = $tree->getTree();
	}
	//print "<pre>";
	//print_r($_GET);
	//print "</pre>";
	
	$search_categories = NULL;
	
	foreach ($decendants AS $key => $value) {
		$search_categories .= $decendants[$key]['category_id'] . ',';
	}
	
	$search_categories = substr ($search_categories, 0, -1);

	// Number of records to show.
    $display = $ProductDisplay;
	
	// formulate serch query.
	switch ($_GET['search_type']) {
		
		case 'part':
			$search_query = explode(" ", $_GET['search_query']);
	
			foreach ($search_query AS $key => $value) {
				$search_query[$key] = "%" . $value;
			}
	
			$search_query = implode("", $search_query)."%";
			$cat_search = "WHERE (category LIKE '$search_query')";
			$product_search = "WHERE (p.description LIKE '$search_query' OR p.product_name LIKE '$search_query')";
			break;
			
		case 'exact':
			$search_query = $_GET['search_query'];
			$cat_search = "WHERE (category LIKE '$search_query')";
			$product_search = "WHERE (p.description LIKE '$search_query' OR p.product_name LIKE '$search_query')";
			break;
			
		case 'all':
			$search_query = explode(" ", $_GET['search_query']);
	
			foreach ($search_query AS $key => $value) {
				$search_query_bits[$key] = "(p.description LIKE '%$value%' OR p.product_name LIKE '%$value%')";
				
				$cat_search_bits[$key] = "(category LIKE '%$value%')";
			}
			
			$product_search = "WHERE (" . implode(" OR ", $search_query_bits). ")";
			
			$cat_search = "WHERE (" . implode(" OR ", $cat_search_bits). ")";
			break;
	
	}
	
	// get $cat_id
	$query = "
		SELECT category_id,lft
		FROM product_category
		$cat_search
		ORDER BY lft ASC
		"; // Standard query
	
	$result = mysql_query ($query);

    $cat_ids = array();
    $cat_id = array();
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$cat_ids[] = $row['category_id'];
	}
	
	if (count($cat_ids) > 0) {
		foreach ($cat_ids as $key => $value) {
			$tree->setId($value);
			$cat_decendants = $tree->getDecendants();
		
			//$cat_id = NULL;
	
			foreach ($cat_decendants AS $key => $value) {
				$cat_id[] = $cat_decendants[$key]['category_id'];
			}
	
		//$cat_id = substr ($cat_id, 0, -1);
		
		}
	}
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.
        $query = "
		(SELECT product_id, category
		FROM products AS p, product_category AS pc
		$product_search
		AND p.category_id IN ($search_categories)
		AND p.category_id=pc.category_id
        )";
		/*
		if (count($cat_id) > 0) {
			$query .= "
				UNION
				(SELECT product_id, category
				FROM products AS p, product_category AS pc
				WHERE p.category_id IN (";
			foreach ($cat_id as $id) {
				$query .= "$id,";
			}
			$query = substr($query,0,-1);
			$query .= ")
				AND p.category_id=pc.category_id
				AND p.enabled=1
				AND p.discontinued=0
                )
			";
		}
		*/
		 // Standard query
		
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
	(SELECT product_id, p.category_id, size, product_name, price, p.description, p.image, p.image_status, quantity, tax_rate, postunit, vat_inc, lft, enabled, discontinued
	FROM products AS p, product_size AS ps, tax_codes AS tc, tax_rates AS tr, product_postunit AS w, product_category AS pc
	$product_search
	AND p.category_id IN ($search_categories)
	AND p.category_id=pc.category_id
	AND p.size_id=ps.size_id 
	AND p.tax_code_id=tc.tax_code_id 
	AND tc.tax_rate_id=tr.tax_rate_id
	AND p.postunit_id=w.postunit_id
    )";
	/*
	if (count($cat_id) > 0) {
		$query .= "
			UNION
			(SELECT product_id, p.category_id, size, product_name, price, p.description, p.image, p.image_status, quantity, tax_rate, postunit, vat_inc, lft, enabled, discontinued
			FROM products AS p, product_size AS ps, tax_codes AS tc, tax_rates AS tr, product_postunit AS w, product_category AS pc
			WHERE p.category_id IN (";
		foreach ($cat_id as $id) {
			$query .= "$id,";
		}
		$query = substr($query,0,-1);
		$query .= ")
			AND p.category_id=pc.category_id
			AND p.size_id=ps.size_id 
			AND p.tax_code_id=tc.tax_code_id 
			AND tc.tax_rate_id=tr.tax_rate_id
			AND p.postunit_id=w.postunit_id
			AND p.enabled=1
			AND p.discontinued=0
            )";
	}
	*/
	$query .= "
	ORDER BY lft ASC, product_name ASC
	LIMIT $start, $display
	";
	//print "<pre>";
	//print_r($query);
	//print "</pre>";
    $result = mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
	
	//globals();
    
    if ($num > 0) { // If it ran OK, display the records.

        echo "<br />";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo '<p class="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
				echo '<a href="javascript:productSearch(' . ($start - $display) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
					echo '<a href="javascript:productSearch(' . (($display * ($i - 1))) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        	// If it's not the last page, make a Next button.
        	if ($current_page != $num_pages) {
				echo '<a href="javascript:productSearch(' . ($start + $display) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">Next</a> ';
            
        	}

        	echo '</p><br />';

        } // End of links section.
		
		print "<div style=\"padding-right:158px;\"><br />";
		print "<table border=\"0\" style=\"width:100%;\">"; // start table

        // Retrieve and print every record.
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			if ($row['quantity'] != 0) {
                // Set picture status.
                $product_img_dir = "/shop/images/";

                //$category_path = NULL;
                $category = NULL;
                foreach ($tree->pathway($row['category_id']) as $id => $path) {

                    //$category_path .= "/" . strtolower (str_replace (" ", "_", str_replace ("/", "_",$path['category'])));
                    $category .= " - " . $path['category'];

                }

                $category = substr($category,3);

                //$img_dir = $product_img_dir . $category_path;
                $img = $product_img_dir.$row['image'];

                $img = Utility::getShopImage($img);

                print "<tr id=\"pid{$row['product_id']}\">";
                //print "<table><tr>";
                print "<td valign=\"top\"><a href=\"#productList\"><img src=\"/admin/images/top03.gif\" class=\"Tips\" title=\"Shop Tip\" rel=\"Click to scroll to the top of the page\"/></a></td>";
                //print "<tr>\r\n";
                print "<td>\r\n";
                print "<div>";
                print "<b>{$row['product_name']}</b><br />{$row['description']}<br />size: {$row['size']}<br />";

                if ($row['postunit'] > 0) {

                    print "weight: " . number_format ($row['postunit'], 0) . " grams<br />";
                }

                print "<b>Price &pound;" . number_format(($row['price'] + $tax), 2) . "</b><br />";

                $avail = true;

                if ($StockControl == 1 && $row['quantity'] != -1) {
                    if ($row['quantity'] > 0) {
                        print '<b>Quantity Available: <span id="pid'.$row['product_id'].'Qty">'.$row['quantity'].'</span></b>';
                    } elseif ($row['discontinued'] == 1) {
                        print  '<b><span id="pid'.$row['product_id'].'Qty">Item Discontinued</span></b>';
                        $avail = false;
                    } elseif ($row['enabled'] == 0 && $row['quantity'] == -1) {
                        print '<b><span id="pid'.$row['product_id'].'Qty">Out of stock</span></b>';
                        $avail = false;
                    } else {
                        print '<b><span id="pid'.$row['product_id'].'Qty">Out of stock</span></b>';
                        $avail = false;
                    }
                } elseif ($row['discontinued'] == 1) {
                    print  '<b><span id="pid'.$row['product_id'].'Qty">Item Discontinued</span></b>';
                    $avail = false;
                } elseif ($row['enabled'] == 0) {
                    print '<b><span id="pid'.$row['product_id'].'Qty">Out of stock</span></b>';
                    $avail = false;
                }

                print "</div>";
                print "</td>";

                if ($row['image_status'] == 1) {
                    print "<td>";
                    print "<div>";
                    if ($avail) print "<a href=\"cart.php?action=add&pid={$row['product_id']}\">";
                    print "<img src=\"$img\" class=\"item Tips\" style=\"border: 3px double #AFA582;\" alt=\"{$row['product_name']}\" title=\"Shop Tip\" rel=\"Drag this image and drop it onto Your Cart to add this product to your shopping basket\"/>";
                    if ($avail) print "</a>";
                    print "</div>";
                    print "</td>";
                }

                print "<td style=\"width:90px;\">\r\n";
                if ($avail) print "<table><tr><td class=\"button Tips\" title=\"Shop Tip\" rel=\"Click to add to cart\"><a class=\"cart_buttons\" href=\"cart.php?action=add&pid={$row['product_id']}\">Add to Cart</a></td></tr></table>";
                print "</td>\r\n";
                print "</tr>\r\n"; // end row

                //print "<tr><td></td><td colspan=\"3\"><hr /></td></tr></table></tr>\r\n";
            }
	
		} // end of While loop
	
		print "</table>";
		print "</div>";
		
		// Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo '<p class="center">';
            // Determine what page the script is on.
            if ($current_page != 1){
				echo '<a href="javascript:productSearch(' . ($start - $display) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
					echo '<a href="javascript:productSearch(' . (($display * ($i - 1))) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        	// If it's not the last page, make a Next button.
        	if ($current_page != $num_pages) {
				echo '<a href="javascript:productSearch(' . ($start + $display) . ', ' . $num_pages . ', ' . $_GET['search_id'] . ', \'' . $_GET['search_query'] . '\', \''.$_GET['search_type'].'\')">Next</a> ';
            
        	}

        	echo '</p><br />';

        } // End of links section.
		
        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        print "<h3>I'm sorry, I can't find anything that matches your query</h3>";
    }
	
	mysql_close();
} else {
	//header("Location: $merchant_website");
	//exit();
}

ob_end_flush();


?>
