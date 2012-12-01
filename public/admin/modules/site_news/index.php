<?php // index.php (administration side) Friday, 8 April 2005
// This is the Site News for the admin side of the site.

// Set the page title.
$page_title = "Site News Overview";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	?>
	<table>
		<tr>
			<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="view_news.php" class="Link">:: View News</a></td>
		</tr>	
		<tr>
			<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="add_news.php" class="Link">:: Add News</a></td>
		</tr>
	</table>
	<?php				
									  
}	



// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>