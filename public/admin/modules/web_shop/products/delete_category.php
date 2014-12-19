<?php // view_order.php Tuesday, 3 May 2005
// This is the delete catagory page for admin.

// Set the page title.
$page_title = "Delete Category";

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
	
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";

   	if (isset ($_POST['submit'])) {	
	 	
		// Cancel.
		if ($_POST['submit'] == "Cancel") {
			Utility::go('categories.php');
		}
		
		if ($_POST['submit'] == "Discontinue") {
			
			$tree->setId($_POST['pcid']);
			$decendants = $tree->getDecendants();
			
			$cats = array();
			
			foreach ($decendants as $row) {
				$cats[] = $row['category_id'];
			}
			
			$cats = implode(',', $cats);
			
			$query = "UPDATE product_category SET discontinued=1 WHERE category_id IN ($cats)";
			
			$result = mysql_query($query);
			
			if ($result) {
				$query = "UPDATE products SET discontinued=1 WHERE category_id IN ($cats)";
				$result = mysql_query($query);
			}
			
			Utility::go ('categories.php');
		}
		
		// Delete Group.
		if ($_POST['submit'] == "Delete") {
			
			$pcid = $_POST['pcid'];
			
			// delete images in this category.
			
			foreach ($tree->getDecendants() as $row) {
			
				$img = array();
				$query = "SELECT image FROM products WHERE category_id={$row['category_id']}";
				
				$result = mysql_query($query);
				while ($rows = mysql_fetch_array($result,MYSQL_NUM)) {
					if (is_file($_SERVER['DOCUMENT_ROOT']."/shop/images/".$rows[0])) {
						unlink($_SERVER['DOCUMENT_ROOT']."/shop/images/".$rows[0]);
					}
				}
			
			}
			
			// Update category table.
			$tree->removeAll ($pcid);
			
			// Create site map from menu links in database.
			new SiteMap();
			
            Utility::go ('categories.php');
			
		 }
   	
	} else {
		
		$tree->getCategory();
		$cat = $tree->getField('category');
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr><td colspan="3" align="center" style="border:2px dashed red;background-color:white;">
			<img src="<?=$_SERVER['DOCUMENT_ROOT']?>/admin/images/actionwarning.png" style="vertical-align:middle;" />
			<span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">Deleting this category will:-
			<ol>
				<li>Delete all sub categories</li>
				<li>Orphan all the products</li>
				<li>Delete all the image files</li>
			</ol>
		belonging to this category and it's sub categories.</span><br />
		<span style="vertical-align:middle;font-weight:bold;font-variant:small-caps;color:red;">
			Deleting this categories will delete it from all invoices.<br />
			Why not disable it for now or discontinue it.
		</span></td></tr>
		<tr><td align="right"><b>Category</b></td><td><?=$cat?></td></tr>
		<input type="hidden" name="pcid" value="<?=$_GET['pcid']?>" />
		<input type="hidden" name="category" value="<?=$cat?>" />
		<tr>
			<td align="center">
				<input type="submit" name="submit" value="Discontinue" />
			</td>
			<td align="center">
				<input type="submit" name="submit" value="Delete" />
			</td><td align="center">
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

?>