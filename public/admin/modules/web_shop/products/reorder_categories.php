<?php // view_order.php Tuesday, 3 May 2005
// This is the edit catagory page for admin.

// Set the page title.
$page_title = "Reorder Categories";

$custom_headtags = '
<script type="text/javascript" src="./sortable_nested_list.js"></script>
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	
	// start tree class
	$tree = new NestedTree('product_category', $_GET['pcid'], 'category', $dbc);
	
	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	require_once ('menu_links.php');
	
	print "</td>";
	print "<td>";
	
	print "<div id=\"category_list\">";
	print "<ul id=\"categories\" class=\"\">";
	
	// Retrieve all children
	$row = $tree->getTree();
	foreach ($row as $key => $value) {
		
		print "<li id=\"{$row[$key]['category_id']}\" class=\"\">";
		print "<p>".$row[$key]['category']."</p>";
		
		$children = (($row[$key]['rgt'] - $row[$key]['lft']) - 1) / 2;
				
		if ($children > 0) print "<ul id=\"\" class=\"\">";
				
		if ($row[$key]['depth'] > 0) {
				
			// find the end of the array.
			$end = end($row);
				
			if ($row[$key]['category_id'] == $end['category_id']) {
				print str_repeat("</li></ul><span>", $row[$key]['depth']);
				print "</li>";
			} else if ($row[$key + 1]['depth'] < $row[$key]['depth']) {
				print str_repeat("</li></ul>", ($row[$key]['depth'] - $row[$key + 1]['depth']));
				print "</li>";
			} else {
				if ($children == 0) print "</li>";
			}	
		} else {	
			if ($children == 0) print "</li>";
		}
		
	}
	
	print "</ul>";
	print "</div>";
	
	print "</td></tr></table>";

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>