<?php
// view_order.php Tuesday, 3 May 2005
// This is the add catagory page for admin.

// Set the page title.
$page_title = "Add Category";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.

if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);

	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";

	require_once ('menu_links.php');

	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";

   	if (isset ($_POST['submit'])) {

	 	$error = NULL;

		// Valadate the data.
		if ($_POST['submit'] == "Add Category") {

			if ($_POST['category']) {
				$category = escape_data (ucwords (trim ($_POST['category'])));
			} else {
				$category = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a category<span></p>";
			}

			if (isset ($_POST['insert_type'])) {

				$insert_type = escape_data (ucwords (trim ($_POST['insert_type'])));

			} else {

				$insert_type = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please choose an insert type<span></p>";

			}

			$parent_id = $_POST['parent'];

			// If all is well.
			if ($category && $insert_type) {

				if ($tree->getCategory($category) == 0) {
					
					$ident= strtolower (Utility::filterString($category));
					
					$update = array (
						'category_id' => 'NULL',
						'ident' => $ident,
						'category' => $category,
						'image' => 'NULL',
						'image_status' => 1
					);

					$category_id = $tree->insert($parent_id, $update, $_POST['insert_type']);
					
					// Create site map from menu links in database.
					new SiteMap();

                    Utility::go ('categories.php');

				} else {
					 print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This Catagory already exists<span></p>";
				}

			} else {
				?>
				<div class="box">
				<?=$error?>
				</div>
				<?php
			}

		}

	} else {

		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<tr><td align="right"><b>Catagory</b></td><td><input type="text" name="category" value="" maxlength="60" size="20" /></td></tr>

		<tr>
			<td align="right"><b>Insert Type</b></td>
			<td>
				As new sub category at top <input type="radio" name="insert_type" value="new child" /><br />
				<!-- Before: <input type="radio" name="insert_type" value="new child" /><br /> -->
				After this category: <input type="radio" name="insert_type" value="after child" />
			</td>
		</tr>

		<tr><td align="right"><b>Parent</b></td><td>
			<?php
			$r = "<select name=\"parent\" class=\"inputbox\" size=\"10\">";
			$r .= "<option value=\"0\" selected=\"selected\">Top</option>";
			foreach ($tree->getTree() as $row) {
				$r .= "<option value=\"{$row['category_id']}\">";
				$r .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth'] + 1)).$row['category']."\n";
				$r .= "</option>";
			}
			$r .= "</select>";
			print $r;
			?>
		</td></tr>

		<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Add Category" /></td></tr>
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