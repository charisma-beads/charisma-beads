<?php // view_news.php (administration side) Friday, 8 April 2005
// This is the View News page for the admin side of the site.

// Set the page title.
$page_title = "View News";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php'); 

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else { 

	$link1 = explode ('/', $https);
	$link2 = explode ('/', $merchant_website);
	
	print "<p><a href=\"index.php\">Back to Overview</a></p>";
    
	// Number of records to show.
    $display = $news_display;
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.
        $query = "SELECT blog_id, title, entry, DATE_FORMAT(date_entered, '%W %D %M %Y') AS date FROM news_blog ORDER BY date_entered DESC"; // Standard query
        $query_result = mysql_query ($query);
        $num_records = @mysql_num_rows ($query_result);
        
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
    $query = "SELECT blog_id, title, entry, DATE_FORMAT(date_entered, '%W %D %M %Y') AS date FROM news_blog ORDER BY date_entered DESC LIMIT $start, $display";
    $result = @mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
    
    if ($num > 0) { // If it ran OK, display the records.

        echo "<br />";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo "<div><p align=\"center\">";
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_news.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_news.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_news.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';
            
        }

        echo '</p></div>';

        } // End of links section.

        // Retrieve and print every record.
	while ($row = mysql_fetch_array ($result)) {
		if ( $link1[(count($link1) - 1)] != $link2[(count($link2) - 1)]) {
			
			$data = str_replace("src=\"..", "src=\"/{$link1[(count($link1) - 1)]}", $row['entry']);
		} else {
			
			$data = str_replace("src=\"..", "src=\"", $row['entry']);
		}
		
		print ("<div><h2>{$row['title']}</h2><p align=\"left\"><b>{$row['date']}</b></p><p align=\"left\">{$data}</p></div><div align=\"center\"><a href=\"edit_entry.php?id={$row['blog_id']}\" class=\"view\" ><img src=\"/admin/images/edit.png\" style=\"border:0px;\"/>Edit Entry</a>&nbsp<a href=\"delete_entry.php?id={$row['blog_id']}\" class=\"view\" ><img src=\"/admin/images/delete.png\" style=\"border:0px;\"/>Delete Entry</a></div>");
        }
																			    
        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo "<div><p align=\"center\">";
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="view_news.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="view_news.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="view_news.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';
            
        }

        echo '</p></div>';

        } // End of links section.
		
        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        echo '<h3>There are currently no news enteries.</h3>';
    }
    
    mysql_close(); // Close the database connection.
	
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>