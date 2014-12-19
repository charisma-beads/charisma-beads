<?php // news.php Tuesday, 3 May 2005
// This is the news page for the site.

// Set the page title.
$page_title = "News";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// Number of records to show.
    $display = $news_display;
    
    // Determine how many pages there are.
    if (isset($_GET['np'])) {
        $num_pages = $_GET['np'];
    } else { // Need to determine.
        $query = "SELECT title, entry, DATE_FORMAT(date_entered, '%W %D %M %Y') AS date FROM news_blog ORDER BY date_entered DESC"; // Standard query
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
    $query = "SELECT title, entry, DATE_FORMAT(date_entered, '%W %D %M %Y') AS date FROM news_blog ORDER BY date_entered DESC LIMIT $start, $display";
    $result = @mysql_query ($query); // Run the query.
    $num = mysql_num_rows ($result); // How many users are there?
    
    if ($num > 0) { // If it ran OK, display the records.

        echo "<br />";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo '<p class="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="news.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="news.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="news.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';
            
        }

        echo '</p><br />';

        } // End of links section.

        // Retrieve and print every record.
	while ($row = mysql_fetch_array ($result)) {
		print "<div class=\"box\">" . "<h1 style=\"text-align:center;\">{$row['title']}</h1>
		<p><b>{$row['date']}</b></p>" . 
		nl2br($row['entry']) . "<br />
		<hr style=\"width:75%; height:6px; text-align:center; border:3px ridge skyblue;\"></p></div>\r\n";
        }
		
		echo "<br />";

        // Make the links to other pages, if necessary.
        if ($num_pages > 1) {

            echo '<p class="center">';
            // Determine what page the script is on.
            $current_page = ($start/$display) + 1;
            
            // If it's not the first page, make a previous button.
            if ($current_page != 1){
                echo '<a href="news.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages.
            for ($i = 1; $i <= $num_pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="news.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

        // If it's not the last page, make a Next button.
        if ($current_page != $num_pages) {
            echo '<a href="news.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a> ';
            
        }

        echo '</p><br />';

        } // End of links section.
		
        mysql_free_result ($result); // Free up the resoures.

    } else { // If there are no registered users.
        echo '<h1>There are currently no enteries.</h1>';
    }
    
    mysql_close(); // Close the database connection.  
	

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/html_bottom.php');
			  
?>