<?php // index.php (administration side) Friday, 8 April 2005
// This is the home page for the admin side of the site.

// Set the page title.
$page_title = "Site Administration";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');	

// Print a message based on authentication.
if (!$authorized) {
   
   echo "<p>Please enter a valid username and password! Click <a href=\"{$_SERVER['DOCUMENT_ROOT']}/index.php\">here</a> to try again!<p>"; 

} else {
    print "<h2>Welcome {$_SESSION['first_name']}</h2>";
    ?>
    <div id="adminform">
    <fieldset class="adminform">
	<legend>PHP Information</legend>
		<table class="adminform">
		<thead>
		<tr>
			<th colspan="2">
				&nbsp;
			</th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<th colspan="2">
				&nbsp;
			</th>
		</tr>
		</tfoot>
		<tbody>
		<tr>
			<td>
				<?php
				ob_start();
				phpinfo();
				$phpinfo = ob_get_contents();
				ob_end_clean();

				preg_match_all('#<body[^>]*>(.*)</body>#siU', $phpinfo, $output);
				$output = preg_replace('#<table#', '<table class="adminlist" align="center"', $output[1][0]);
				$output = preg_replace('#(\w),(\w)#', '\1, \2', $output);
				$output = preg_replace('#border="0" cellpadding="3" width="600"#', 'border="0" cellspacing="1" cellpadding="4" width="95%"', $output);
				$output = preg_replace('#<hr />#', '', $output);
				$output = str_replace('<div class="center">', '', $output);
				$output = str_replace('</div>', '', $output);

				echo $output;
				?>
			</td>
		</tr>
		</tbody>
		</table>
</fieldset>
</div>
<?php
}	

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>