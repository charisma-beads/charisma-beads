<?php 
// view_order.php Tuesday, 3 May 2005
// This is the delete product page for admin.

// Set the page title.
$page_title = "Delete Product";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	require_once ('menu_links.php');
	
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";

   	if (isset ($_POST['submit'])) {
		
		// start tree class
		
		$tree = new NestedTree('product_category', NULL, 'category', $dbc);
	 	
		// Cancel.
		if ($_POST['submit'] == "Cancel") {
		
            Utility::go ('index.php');
		}
		
		if ($_POST['submit'] == "Discontinue") {
			$query = "UPDATE products SET discontinued=1 WHERE product_id={$_POST['pid']} LIMIT 1";
			$result = mysql_query($query);
            Utility::go ('index.php');
		}
		
		// Delete Product.
		if ($_POST['submit'] == "Delete") {
			
			$pid = $_POST['pid'];
			
			// Delete Picture.
			$query = "
				SELECT image, category_id
				FROM products
				WHERE product_id=$pid
			";
			$result = mysql_query ($query);
			$row = mysql_fetch_array ($result, MYSQL_NUM);
			
			$product_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/images/";
			//$category = NULL;
			
			//foreach ($tree->pathway($row[1]) as $id => $path) {

				//$category .= "/" . strtolower (str_replace (" ", "_", str_replace ("/", "_",$path['category'])));

			//}

			//$img_dir = $product_img_dir . $category;
			$line_img = $product_img_dir . $row[0];
			
			unlink ($line_img);
			
			
			$query = "
					DELETE FROM products
					WHERE product_id=$pid
					";
			//print $query;
			$result = mysql_query ($query);
				
            Utility::go ('index.php');
			
		 }
   	
	} else {
   		
		$query = "
			SELECT product_name, hits
			FROM products
			WHERE product_id={$_GET['pid']}
			";
		$result = mysql_query ($query);
		$product = mysql_result ($result, 0, 'product_name');
		$hits = mysql_result ($result, 0, 'hits');
		
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="3" align="center" style="border:2px dashed red;background-color:white;"><img src="/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this product will delete it from all invoices.<br />Why not disable it for now or discontinue it.</span></td></tr>
		<tr><td align="right"><b>Product</b></td><td><?=$product?></td></tr>
		<input type="hidden" name="pid" value="<?=$_GET['pid']?>" />
		<tr>
			<td align="center">
				<input type="submit" name="submit" value="Discontinue" />
			</td>
			<td align="center">
				<?php if ($hits == 0) { ?>
				<input type="submit" name="submit" value="Delete" />
				<?php } ?>
			</td>
			<td align="center">
				<input type="submit" name="submit" value="Cancel" />
			</td>
		</tr>
		</form> 
		</table>
		</div>
   		<?php
   
   	}
	
	print "</td></tr></table>";
	mysql_close(); // Close the database connection.

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');