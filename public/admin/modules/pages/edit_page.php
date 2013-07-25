<?php 

// Set the page title.
$page_title = "Edit Page Content";

$custom_headtags = '
<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/admin/js/tinymce_init.js"></script>
<!-- /TinyMCE -->
';
// Include configuration file for error management and such. 

include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');
 
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {  	

	if (isset ($_POST['pid'])) {

		print "<div style=\"text-align:center;\">";
		print '<h1><a href="index.php">Click To return to page overview</a></h1>'; 
	 	
		$data = escape_data($_POST['content']);
			
		
		// Make the query.
		$query = "
		UPDATE pages
		SET content='$data', date_entered=NOW()
		WHERE page_id={$_POST['pid']}
		";
		$result = mysql_query($query);
		
		if (mysql_affected_rows() == 1) {
			// Create site map from menu links in database.
			new SiteMap();
			
			print '<p>Your update to <b>' . $_POST['page'] . '</b> has been successful.</p>';
		} else {
			
			print '<p>Your update could not be stored due to a system error.</p>';
			
		}
		print "</div>";
	} else {
	
		$query = "
		SELECT content, page
		FROM pages
		WHERE page_id={$_GET['pid']}
		";
		$result = mysql_query($query);
		$data = mysql_fetch_array ($result, MYSQL_NUM);
		
		// Create an instance of the editor
		?>
		<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
		<textarea name="content"><?=$data[0];?></textarea>
		<input type="hidden" name="pid" value="<?php print $_GET['pid']; ?>" />
        <input type="hidden" name="page" value="<?php print $data[1]; ?>" />
		</form>
		<?php
	
	}
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
?>
