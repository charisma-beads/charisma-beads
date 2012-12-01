<?php // delete_entry.php (administration side) 14 May 2005
// This is the delete user page for the admin side of the site.

// Set the page title.
$page_title = "Delete User";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else { 

	print "<p><a href=\"index.php\">Back to Overview</a></p>";
    
	if (isset ($_POST['submit'])) { // Handle the form.
	
		// Define the query.
		$query = "DELETE FROM newsletter 
				WHERE newsletter_id={$_POST['id']} LIMIT 1";
		$result = mysql_query ($query); // Execute the query.
				
		$query = "UPDATE customers SET newsletter_id=0 WHERE newsletter_id={$_POST['id']} LIMIT 1";
		$result = mysql_query ($query); // Execute the query.
		
		// Report on the result.
		if (mysql_affected_rows() == 1) {
			print ("<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" />The User has been deleted.</p></span><p align=\"center\"><a href=\"view_users.php\" class=\"view\" ><img src=\"/admin/images/view.png\" style=\"border:0px;\"/>View Users</a></p>");
		} else {
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/images/actionno.png\" />Could not delete the user because: <b>" . mysql_error() . "</b>. The query was " . $query . ".</p></span><p align=\"center\"><a href=\"view_users.php\" class=\"view\" ><img src=\"/admin/images/view.png\" style=\"border:0px;\"/>View Users</a></p>";
		}
		
	} else { // Display the form.
	
		// Check for a valid entry ID in the URL.
		if (is_numeric ($_GET['id'])) {
		
			// Define the query.
			$query = "
				SELECT newsletter_id, CONCAT(first_name, ' ', last_name) AS name 
				FROM customers
				NATURAL JOIN newsletter
				WHERE newsletter_id={$_GET['id']}";
			if ($result = mysql_query ($query)) { // Run the query.
			
				$row = mysql_fetch_array ($result); // Retrieve the information.
				
				// Make the form.
				print "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">
				<div align=\"center\">
				<span class=\"smcap\" ><p class=\"info\" align=\"center\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionwarning.png\" />Are you sure you want to delete this user?</p></span>
				</div>
				<div align=\"left\">
				<h3>" . $row['name'] . "</h3><br />
				<input type=\"hidden\" name=\"id\" value=\"" . $_GET['id'] . "\" />		  
				</div>
				<div align=\"center\">
				<input type=\"submit\" name=\"submit\" value=\"Delete!\" />
				</div>
				</form>";
				
			} else { // Couldn't get the information.
				print "<div><span class=\"smcap\" ><p class=\"fail\" align=\"center\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" />Could not retrieve the entry because: <b>" . mysql_error() . "</b>. The query was $query.</p></span></div>";
			}
			
		} else { // No ID set.
			print "<p align=\"center\"><b>You must of made a mistake using this page.</b></p>";
		}
		
	} // End of IF.
	
	mysql_close(); // Close the database connection.
	
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>