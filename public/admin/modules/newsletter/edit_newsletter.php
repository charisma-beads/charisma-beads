<?php

// Set the page title.
$page_title = "Edit Newsletter";

$custom_headtags = '
<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/admin/js/tinymce_init.js"></script>
<!-- /TinyMCE -->
';
// Include configuration file for error management and such. 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
   	
	if (isset ($_POST['newsletter'])) {
	
		print "<div style=\"text-align:center;\">";
		print '<h1><a href="index.php">Click To return to page overview</a></h1>';
	 
		$page = $_SERVER['DOCUMENT_ROOT'] . "/admin/modules/newsletter/01/content.txt";
		
		if ($fp = fopen ($page, 'wb')) {
			
			$data = Utility::escape($_POST['newsletter']);
			
			//$data = str_replace("src=\"", "src=\"$merchant_website", $data);
		   	fwrite ($fp, "$data");
			fclose ($fp);
			
			print '<p>Your update to ' . $page . ' has been successful.</p>';
			
			
		} else {
			
			print '<p>Your update could not be stored due to a system error.</p>';
		}
	
	 	print "</div>";
		
	} else {
		$data = null;
		$strHTML = null;
		
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/newsletter/01/content.txt')) {
			$data = file ($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/newsletter/01/content.txt');
		}
		
		for ($d = 0; $d < count ($data); $d++) {
			$strHTML .= $data[$d]; 
		}
		
		$strHTML = str_replace("src=\"$merchant_website", "src=\"", $strHTML);
		// Create an instance of the editor
		?>
		<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
		<textarea name="newsletter"><?=$strHTML;?></textarea>
		</form>
		<?php
	}
	
}
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
?>
