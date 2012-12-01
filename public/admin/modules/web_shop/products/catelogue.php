<?php

// Set the page title.
$page_title = "Products";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	$tmp_files = glob($_SERVER['DOCUMENT_ROOT'].'/admin/tmp/*.*');
	 
	foreach ($tmp_files as $Key => $value) {
		unlink($value);
	}

	/*
	Product name/number
	Category (all levels)
	Description
	Product size
	Product weight
	Price
	*/
	
	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);
	
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	require_once ('menu_links.php');
	
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";
	
	if (isset($_POST['pcf'])) {
		
		$query = "
			SELECT
				product_name,
				category,
				description,
				size,
				postunit,
				price,
				p.category_id,
				lft
			FROM
				products AS p,
				product_category AS pc,
				product_size AS ps,
				product_postunit AS pp
			WHERE
				p.category_id=pc.category_id
			AND
				p.size_id=ps.size_id
			AND
				p.postunit_id=pp.postunit_id
			AND
				p.discontinued=0
		";
		if ($_POST['pcf'] > 0)  {
			$tree->setId($_POST['pcf']);
			$decendants = $tree->getDecendants();
			
			$search_categories = NULL;
	
			foreach ($decendants AS $key => $value) {
				$search_categories .= $decendants[$key]['category_id'] . ',';
			}
	
			$search_categories = substr ($search_categories, 0, -1);
			
			$query .= "AND p.category_id IN ($search_categories)";
		}
		$query .= "
			ORDER BY
				lft ASC,
				product_name ASC
		";

		$result = mysql_query($query);

		$delimiter = "\t";
		$enclosure = '"';
		if ($_POST['pcf'] > 0) {
			$file = $tree->pathway($_POST['pcf']);
			$c = count($file);
			$file = end($file);
			$file = str_replace(" ", "_", strtolower(str_replace("/", "_", $file['category'])));
		} else {
			$file = "catelogue";
		}
		
		$file = $file.".csv";
		//$output = "Product name/number\tCategory\tDescription\tProduct size\tProduct weight\tPrice\r\n";
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$data_row[] = $row;
		}
		
		$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/admin/tmp/'.$file, 'w');
		
		foreach ($data_row as $key => $value) {
			
			$row = array();
			
			if ($data_row[$key - 1]['category'] != $value['category']) {
				
				$value['category'] = NULL;
				
				foreach ($tree->pathway($value['category_id']) as $id => $path) {
					$value['category'] .= $path['category'] . "::";
				}
				
				$category = array(substr($value['category'],0,-2));
				
				fputcsv($handle, $category, $delimiter, $enclosure);
			}
			
			$row[] = $value['product_name'];
			
			$row[] = html_entity_decode(strip_tags($value['description']),ENT_QUOTES, 'UTF-8');
			
			$row[] = number_format($value['postunit'],0).'gms';
			
			$row[] = '£'.$value['price'];
			
			fputcsv($handle, $row, $delimiter, $enclosure);
		}

		fclose($handle);
		
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

		
	} else {
		?>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<p>Please select which category you wish to download:</p>
			<select name="pcf" onChange="this.form.submit()">
				<option style="font-weight:bold">Select One</option>
		
				<?php // Retrieve all the product lines and add to the pull down menu.
		
				print "<option value=\"0\"";
				
				print ">All Categories</option>";
	
				foreach ($tree->getTree() as $row) {
					print "<option value=\"{$row['category_id']}\"";
					
					print ">".str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth']));
					if ($row['depth'] > 0) print "&bull;&nbsp;";
					print "{$row['category']}</option>\r\n";
				}
			?>
			</select>
		</form>
		<?php
	}
	
	print "</td></tr></table>";
	mysql_free_result ($result); // Free up the resoures.
}
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
?>