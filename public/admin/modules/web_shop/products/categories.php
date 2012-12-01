<?php // view_order.php Tuesday, 3 May 2005
// This is the product Catagories page for admin.

// Set the page title.
$page_title = "Product Categories";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);

	if (isset($_GET['action']) && isset($_GET['pcid'])) {

		switch ($_GET['action']) {

			case 'assend':
				$tree->moveUp($_GET['pcid']);
				break;
			case 'desend':
				$tree->moveDown($_GET['pcid']);
		}

	}

	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";

	require_once ('menu_links.php');

	print "<table class=\"todo_menu\">";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"add_category.php\" class=\"Link\">Add New Category</a></td></tr>";

	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"reorder_categories.php\" class=\"Link\">Reorder Categories</a></td></tr>";

	print "</table>";

	print "</td><td valign=\"top\">";

    // Number of records to show.
    $display = 10;

    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.

        $num_records = $tree->numTree();

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

    $num = $tree->numTree("LIMIT $start, $display"); // How many users are there?

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
                echo '<a href="categories.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }

            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="categories.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="categories.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';

        }

        echo '</p>';

        } // End of links section.

        // Table header.

        echo '<table align="center" cellspacing="2" cellpadding="2" id="test">
		<tr bgcolor="#EEEEEE">
			<td align="center"><b>Category</b></td>
			<td><b>Image</b></td>
			<td><b> </b></td>
			<td><b> </b></td>
		</tr>';

        // Fetch and print all the records.
        $bg = '#EEEEEE'; // Set the background colour.
		$base_dir =  "/shop/images/";

		$data = $tree->getTree();
        foreach ($data as $key => $row) {

			$image = $row['image'];

			if ($row['image_status'] == 1) {
				// Set picture directory.
                $img_file = Utility::getShopImage($base_dir.$image);
				//if (substr($img_file, 0, 1) == 'n') $img_file = $base_dir . $img_file;
                //$img_file = '/shop/cache/' . $img['image'];
			} else {
				$img_file = "image.php?bg=FFFFFF&tc=FF0000&txt=IMAGE OFF";
			}

            $bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.

            print "<tr id=\"pcid{$row['category_id']}\" bgcolor=\"$bg\">\r\n";
			print "<td align=\"left\">".str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth']));
			if ($row['depth'] > 0) print "&bull;&nbsp;";
			print $row['category']."</td>\r\n";

			print "<td><img src=\"$img_file\" /></td>";

			print "<td align=\"center\"><a href=\"edit_category.php?pcid={$row['category_id']}&s=$start&np=$num_pages\"><img src=\"/admin/images/edit.png\" alt=\"Edit catagory\"/></a></td>\r\n";

			print "<td align=\"center\"><a href=\"delete_category.php?pcid={$row['category_id']}\"><img src=\"/admin/images/delete.png\" alt=\"delete catagory\"/></a></td>\r\n";

			print "</tr>\r\n";
        }

        echo '</table>'; // Close the table.

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;

            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="categories.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }

            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="categories.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="categories.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';

        }

        echo '</p></div>';

        } // End of links section.

        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        echo '<h3>There are currently no categories.</h3>';
    }

	print "</td></tr></table>";
	mysql_close(); // Close the database connection.

	if (isset($_GET['pcid'])) {
		?>
		<script>
			var scroll = new Fx.Scroll(window, {
				duration: 1500,
	 			transition: Fx.Transitions.Quad.easeInOut
			});

			scroll.toElement('pcid<?=$_GET['pcid']?>');
		</script>
		<?php
	}

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
