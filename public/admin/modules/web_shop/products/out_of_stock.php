<?php // index.php Friday, 8 April 2005

// Set the page title.
$page_title = "Out Of Stock List";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);
	
	$tmp_files = glob($_SERVER['DOCUMENT_ROOT'].'/admin/tmp/*.*');
	 
	foreach ($tmp_files as $Key => $value) {
		unlink($value);
	}
	
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	require_once ('menu_links.php');
	
	print "</td><td valign=\"top\">";
	
	$query = "
			SELECT product_name, category, lft, rgt, products.category_id
			FROM products, product_category
			WHERE products.category_id=product_category.category_id
			AND products.enabled=0
			AND products.discontinued=0
			ORDER BY lft ASC, product_name ASC
		";
	
	$result = mysql_query($query);
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		$data_row[] = $row;
	}
	
	$data = NULL;
	
	foreach ($data_row as $key => $value) {
		
		if ($data_row[$key - 1]['category'] != $value['category']) {
			
			$data .= "\n";
			foreach ($tree->pathway($value['category_id']) as $id => $path) {

				$data .= $path['category'] . "::";

			}
			
			$data = substr($data,0,-2);
			
			$data .= "\n";
		}
		
		$data .= "\t".$value['product_name']."\n";
		
	}
	
	$file = "out_of_stock.odt";
	
	$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/admin/tmp/'.$file, 'w');
	
	fputs($handle,$data);
	
	fclose($handle);
	
	//print "<pre>";
	//print_r ($data);
	//print "</pre>";
	
	?>
		<p>Please wait while your download starts</p>
		<p>If it does not start in 10 seconds please use this link:</p>
		<a href="/admin/tmp/<?=$file?>"><?=$file?></a>
		<script>
			function saveFile() {
				location = "/admin/tmp/<?=$file?>";
			}
			window.addEvent('load', function(){
				setTimeout('saveFile()',3000);
			});
			
		</script>
	<?php
			
	print "</td></tr></table>";
	mysql_free_result ($result); // Free up the resoures.

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');