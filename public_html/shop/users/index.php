<?php // login.php Tuesday, 5 April 2005
// This page allows logged-in users to change their details.

// Set the page title.
$page_title = "My Account";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['cid'])) {

    header ("Location: $merchant_website/index.php");
    
} else {
	
	$content .= "<h1>$page_title</h1>";
	
	$content .= '
	<table>
		<tr>
			<td height="25" class="Link"><a href="change_details.php" class="Link">:: Change Address Details</a></td>
		</tr>
		<tr>
			<td height="25" class="Link"><a href="change_password.php" class="Link">:: Change Password</a></td>
		</tr>
		<tr>
			<td height="25" class="Link"><a href="change_newsletter.php" class="Link">:: Newsletter Options</a></td>
		</tr>
	</table>
	
	';
	
	// Number of records to show.
    	$display = $users_display;
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
       	$num_pages = $_GET['np'];
	} else { // Need to determine.
        $query = "SELECT order_id AS oid, customer_id AS cid, invoice, DATE_FORMAT(order_date, '%W %D %M %Y') AS date FROM customer_orders WHERE customer_id={$_SESSION['cid']} ORDER BY order_date DESC"; // Standard query
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
		SELECT order_id, customer_id, invoice, DATE_FORMAT(order_date, '%W %D %M %Y') AS date, order_status
		FROM customer_orders, customer_order_status
		WHERE customer_id={$_SESSION['cid']}
		AND customer_orders.order_status_id=customer_order_status.order_status_id
		ORDER BY order_date DESC
		LIMIT $start, $display
	";
	
    $result = mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
    
    if ($num > 0) { // If it ran OK, display the records.

        $content .= "<br />";
			
		$content .= "<div class=\"box\">";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
		   		
            $content .= '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                $content .= '<a href="index.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    $content .= '<a href="index.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
                    $content .= $i . ' ';
				}
			}

        	// If it's not the last page, make a Next button.
        	if ($current_page != $num_pages) {
            	$content .= '<a href="index.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
			}

        	$content .= '</p>';

		} // End of links section.

        // Table header.
        $content .= '<table align="center" cellspacing="2" cellpadding="2" style="font-size:14px;"><tr bgcolor="#EEEEEE"><td align="center"><b>Order No.</b></td><td align="center"><b>Order Date</b></td></td><td align="center"><b>Order Status</b></td><td align="center"><b>&nbsp;</b></td></tr>';

        // Fetch and $content .= all the records.
        $bg = '#EEEEEE'; // Set the background colour.
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
            $content .= '<tr bgcolor="'.$bg.'"><td align="left">'.$row['invoice'].'</td><td align="left">'.$row['date'].'<td align="left">'.$row['order_status'].'</td><td align="center"><a href="view_order.php?oid='.$row['order_id'].'">View</a></td></tr>';
		}

        $content .= '</table>'; // Close the table.

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
            $content .= '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                $content .= '<a href="index.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    $content .= '<a href="index.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
                    $content .= $i . ' ';
				}
			}

        	// If it's not the last page, make a Next button.
        	if ($current_page != $num_pages) {
            	$content .= '<a href="index.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
			}

        	$content .= '</p></div>';

		} // End of links section.

        mysql_free_result ($result); // Free up the resoures.

	} else { // If there are no registered users.
        $content .= '<h3>You currently have no orders.</h3>';
	}
		
	mysql_close(); // Close the database connection.
	
	
} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
