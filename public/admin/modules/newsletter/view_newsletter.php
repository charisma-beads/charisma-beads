<?php // view_user.php Wednesday, 13 April 2005
// This page allows the administrator to view the current newsletter.

// Set the page title.
$page_title = "View Newsletter";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Check for authorization.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else {  

	print "<p><a href=\"index.php\">Back to Overview</a></p>";

?>	
<iframe id="myframe" src="view.php" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="overflow:visible; width:100%;height:500px;"></iframe>
<?php    
   
}
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>