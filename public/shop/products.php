<?php // catalogue.php Tuesday, 3 May 2005
// This is the Browse Catalogue page for the site.

//globals();

// Number of records to show.
$display = $ProductDisplay;
$tax = 0;

// Determine how many pages there are.
if (isset($_GET['np'])) {
	$num_pages = $_GET['np'];
} else { // Need to determine.
	$query = "
		SELECT product_id 
		FROM products 
		WHERE category_id={$pcid}
		AND enabled=1
		AND discontinued=0
		ORDER BY product_name + 0
	"; // Standard query
	$query_result = mysql_query ($query);

	$num_records = ($query_result === false) ? 0 : mysql_num_rows ($query_result);
	 
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
	SELECT product_id, category_id, size, product_name, price, p.description, image, p.image_status, quantity, tax_rate, postunit, vat_inc, enabled
	FROM products AS p, product_size AS ps, tax_codes AS tc, tax_rates AS tr, product_postunit AS w
	WHERE p.category_id={$pcid}
	AND p.size_id=ps.size_id 
	AND p.tax_code_id=tc.tax_code_id 
	AND tc.tax_rate_id=tr.tax_rate_id
	AND p.postunit_id=w.postunit_id
	AND p.enabled=1
	AND p.discontinued=0
	ORDER BY product_name
	LIMIT $start, $display
";
//print $query;
$result = mysql_query ($query); // Run the query.

$num = (is_resource($result)) ? mysql_num_rows ($result) : 0; // How many users are there?

//globals();

if ($num > 0) { // If it ran OK, display the records.
	
	$content .= "<br />";
	
	if (isset($ident)) {
		$page = $ident . '?';
	} else {
		$page = 'index.php?pcid=' . $pcid . '&';
	}
	
	// Make the links to other pages, if necessary.
	if ($num_pages > 1) {
	
		$content .= '<div class="center"><br />';
		// Determine what page the script is on.
		$current_page = ($start/$display) + 1;
		$page_title .= ' Page ' . $current_page;

		// If it's not the first page, make a previous button.
		if ($current_page != 1){

			$content .= '<a href="'. $page .'s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
		}

		// Make all the numbered pages.
		for ($i = 1; $i <= $num_pages; $i++) {

			if ($i != $current_page) {
 
				$content .= '<a href="'. $page .'s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
			} else {
				$content .= $i . ' ';
			}
		}

		// If it's not the last page, make a Next button.
		if ($current_page != $num_pages) {
			$content .= '<a href="'. $page .'s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';

		}

		$content .= '</div>';

	} // End of links section.
	
	$content .= "<div style=\"padding-right:158px;\"><br />";
	$content .= "<table id=\"productTable\">"; // start table

	// Retrieve and print every record.
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) { 
		//if ($row['enabled'] == 1) {
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

            $content .= "<tr id=\"pid{$row['product_id']}\">";
            //$content .= "<table><tr>";
            $content .= "<td valign=\"top\"><a href=\"#productList\"><img src=\"/admin/images/top03.gif\" class=\"Tips\" title=\"Shop Tip\" rel=\"Click to scroll to the top of the page\"/></a></td>";
            //$content .= "<tr>\r\n";
            $content .= "<td>\r\n";
            $content .= "<div>";
            $content .= "<b>{$row['product_name']}</b><br />{$row['description']}<br />size: {$row['size']}<br />";

            if ($row['postunit'] > 0) {

                $content .= "weight: " . number_format ($row['postunit'], 0) . " grams<br />";
            }

            $content .= "<b>Price &pound;" . number_format(($row['price'] + $tax), 2) . "</b><br />";

            $avail = true;
            
            if ($StockControl == 1 && $row['quantity'] != -1) {
                if ($row['quantity'] > 0) {
                    $content .= '<b>Quantity Available: <span id="pid'.$row['product_id'].'Qty">'.$row['quantity'].'</span></b>';
                } else {
                    $content .= '<b><span id="pid'.$row['product_id'].'Qty">Out of stock</span></b>';
                    $avail = false;
                }
            }
            $content .= "</div>";
            $content .= "</td>";

            if ($row['image_status'] == 1) {
                $content .= "<td>";
                $content .= "<div>";
                if ($avail) {
                	$content .= "<a href=\"cart.php?action=add&pid={$row['product_id']}\">";
                	$content .= "<img src=\"$img\" class=\"item Tips\" style=\"border: 3px double #AFA582;\" alt=\"{$row['product_name']}\" title=\"Shop Tip\" rel=\"Drag this image and drop it onto Your Cart to add this product to your shopping basket\"/>";
                	$content .= "</a>";
                } else {
                	$content .= "<img src=\"$img\" style=\"border: 3px double #AFA582;\" alt=\"{$row['product_name']}\" />";
                }
                $content .= "</div>";
                $content .= "</td>";
            }
            unset($img);
            
            $content .= "<td style=\"width:90px;\">\r\n";
            if ($avail) {
            	$content .= "<table><tr><td class=\"button Tips\" title=\"Shop Tip\" rel=\"Click to add to cart\"><a class=\"cart_buttons\" href=\"cart.php?action=add&pid={$row['product_id']}\">Add to Cart</a></td></tr></table>";
            } else {
            	$content .= "&nbsp;";
            }
            $content .= "</td>\r\n";
            $content .= "</tr>\r\n"; // end row

            //$content .= "<tr><td></td><td colspan=\"3\"><hr /></td></tr></table></tr>\r\n";
        //}
	} // end of While loop
	
	$content .= "</table>";
	$content .= "</div>";
	// Make the links to other pages, if necessary.
    if ($num_pages > 1) {

		$content .= '<div class="center"><br />';
		// Determine what page the script is on.
		$current_page = ($start/$display) + 1;

		if ($current_page != 1){
			$content .= '<a href="' .$page .'s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
		}

		// Make all the numbered pages.
		for ($i = 1; $i <= $num_pages; $i++) {
			if ($i != $current_page) {
				$content .= '<a href="' .$page .'s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
			} else {
				$content .= $i . ' ';
			}
		}

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
			$content .= '<a href="' .$page .'s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';
		}

        $content .= '</div>';

	} // End of links section.
			
	if (isset($_GET['pid'])) {
	$content .='
        <script type="text/javascript">
			var scroll = new Fx.Scroll(window, {
				duration: 2500,
  				transition: Fx.Transitions.Quad.easeInOut
			});
	
			scroll.toElement(\'pid'.$pcid.'\');
		</script>
	';
	}

}

if ($num_rows == 0 && $num == 0)  { // If there are no registered users.
	$content .= '<h1>There are currently no entries.</h1>';
}

?>
