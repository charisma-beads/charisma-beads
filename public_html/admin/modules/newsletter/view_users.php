<?php // view_user.php Wednesday, 13 April 2005
// This page allows the administrator to view all of the current users.

// Set the page title.
$page_title = "Registered Users";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Check for authorization.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else { 
	
	print "<p><a href=\"index.php\">Back to Overview</a></p>";
    
    // Number of records to show.
    $display = $users_display;
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.
        $query = "
			SELECT n.newsletter_id, CONCAT(first_name, ' ', last_name) AS name, first_name, last_name, email, DATE_FORMAT(n.registration_date, '%W %D %M %Y') AS date 
			FROM newsletter AS n,customers AS c
			WHERE n.newsletter_id=c.newsletter_id
			ORDER BY last_name, first_name
		"; // Standard query
        $query_result = mysql_query ($query);
        $num_records = mysql_num_rows ($query_result);
		$num_users = $num_records;
        
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
			SELECT n.newsletter_id, CONCAT(first_name, ' ', last_name) AS name, first_name, last_name, email, DATE_FORMAT(n.registration_date, '%W %D %M %Y') AS date 
			FROM newsletter AS n,customers AS c
			WHERE n.newsletter_id=c.newsletter_id
			ORDER BY last_name, first_name
			LIMIT $start, $display";
	
    $result = @mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
    
    if ($num > 0) { // If it ran OK, display the records.
	
		echo "<h3>There are currently $num_users registered users.</h3>";

        echo "<br />";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
		   	
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_users.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_users.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_users.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p>';

        } // End of links section.

        // Table header.
		print "<div class=\"box\">";
        echo '<table cellspacing="2" cellpadding="2">
        <tr bgcolor="#EEEEEE"><td align="center"><b>Name</b></td><td align="center"><b>Email</b></td><td align="center"><b>Date Registered</b></td><td></td></tr>';

        // Fetch and print all the records.
        $bg = '#EEEEEE'; // Set the background colour.
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
            echo '<tr bgcolor="', $bg, '"><td align="left">', stripslashes($row['name']), '</td><td align="left">', $row['email'], '</td><td align="left">', $row['date'], '</td><td><a href="delete_user.php?id=', $row['newsletter_id'], '" /><img src="/admin/images/delete.png" alt="Delete User"/></td></tr>';
        }

        echo '</table>'; // Close the table.
		
		print "</div>";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {
			
            echo '<p align="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_users.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_users.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_users.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
            
        }

        echo '</p>';

        } // End of links section.

        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        echo '<h3>There are currently no registered users.</h3>';
    }
    
    mysql_close(); // Close the database connection.
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>