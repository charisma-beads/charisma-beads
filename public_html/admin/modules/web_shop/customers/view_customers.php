<?php // view_order.php Tuesday, 3 May 2005
// This is the view customers page for admin.

// Set the page title.
$page_title = "View Customers";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
    /*
    // Number of records to show.
    $display = $users_display;
    if (isset ($_SESSION['view_customers'])) unset ($_SESSION['view_customers']);
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
        $_SESSION['view_customers']['np'] = $_GET['np'];
    } else { // Need to determine.
        $query = "
			SELECT customers.customer_id AS cid, CONCAT(prefix, ' ', first_name, ' ', last_name) AS name
			FROM customers, customer_prefix
			WHERE customers.prefix_id=customer_prefix.prefix_id
			ORDER BY last_name ASC 
			"; // Standard query
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
        $_SESSION['view_customers']['s'] = $_GET['s'];
    } else {
        $start = 0;
    }
    */
    // Make the query.
    
    $query = "
		SELECT customers.customer_id AS cid, CONCAT(prefix, ' ', first_name, ' ', last_name) AS name
		FROM customers, customer_prefix
		WHERE customers.prefix_id=customer_prefix.prefix_id
		ORDER BY last_name ASC 
		
	"; // LIMIT $start, $display
	
    $result = mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
    
    if ($num > 0) { // If it ran OK, display the records.

        echo "<br />";
		
		print "<div class=\"box\">";
		/*
        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
		
            echo '<p align="center">';
			
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_customers.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_customers.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p>';

        } // End of links section.
		*/
        // Table header.
		echo '<center><div id="customers" style="width:250px;height:300px;overflow:auto;">';
        echo '<table align="center" cellspacing="2" cellpadding="2" style="width:100%;">
        <tr bgcolor="#EEEEEE"><td align="center"><b>Name</b></td><td align="center"><b>Orders</b></td></tr>';

        // Fetch and print all the records.
        $bg = '#EEEEEE'; // Set the background colour.
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        	$order_count = mysql_num_rows (mysql_query ("
				SELECT order_id
				FROM customer_orders
				WHERE customer_id={$row['cid']}
			"));
            $bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
			echo '<tr id="cid'.$row['cid'].'" bgcolor="'.$bg.'"><td align="left"><a href="view_orders.php?cid='.$row['cid'].'">'.$row['name'].'</a></td>';
			echo '<td align="center">'.$order_count.'</td></tr>';
        }

        echo '</table>'; // Close the table.
		echo '</div></center>';
		if (isset($_GET['cid'])) {
		?>
		<script>
			var scroll = new Fx.Scroll('customers', {
				wait: false,
   				duration: 1500,
  		 		transition: Fx.Transitions.Quad.easeInOut
			});
			
			window.addEvent("load", function(){
				scroll.toElement('cid<?=$_GET['cid']?>');
			});
		</script>
		<?php
		}
		/*
        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_customers.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_customers.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p></div>';

        } // End of links section.
		*/
        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        echo '<h3>There are currently no customers.</h3>';
    }
	

	mysql_close(); // Close the database connection.

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>