<?php // view_order.php Tuesday, 3 May 2005
// This is the edit catagory page for admin.

// Set the page title.
$page_title = "Edit Category";

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

		// Valadate the data.
		if ($_POST['submit'] == "Change") {

			$error = NULL;

			$pcid = $_POST['pcid'];

			if ($_POST['category']) {
				$cat = escape_data (ucwords ($_POST['category']));
			} else {
				$cat = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a category<span></p>";
			}

			if ($_POST['image']) {
				if ($_POST['image'] != "nopic") {
					$cat_img = "'" . escape_data ($_POST['image']) . "'";
				} else {
					$cat_img = "NULL";
				}
			} else {
				$cat_img = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please select an image<span></p>";
			}

			if (is_numeric ($_POST['image_status'])) {

				$status = escape_data ($_POST['image_status']);

			} else {
				$status = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please select an image<span></p>";
			}

			// If all is well.
			if (!$error) {

				// update img
				mysql_query("
						UPDATE product_category
						SET image=$cat_img
						WHERE category_id=$pcid
					");

				$base_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/images/";

				// If category name has changed rename directory and update database.
				if ($_POST['old_category'] != $cat) {
					$ident= strtolower (Utility::filterString($cat));
					// Update category in database.
					mysql_query ("
						UPDATE product_category
						SET category='$cat', ident='$ident'
						WHERE category_id=$pcid
					");

				}

				// If the image status has changed.
				if (isset($status)) {
					$result = mysql_query ("
						SELECT image_status
						FROM product_category
						WHERE category_id=$pcid
					");
					$row = mysql_result($result,0);

					if ($row != $status) {
						mysql_query ("
							UPDATE product_category
							SET image_status=$status
							WHERE category_id=$pcid
						");
					}
				}
			}

			// Create site map from menu links in database.
			new SiteMap();

		} else {
			?>
			<div class="box">
			<?=$error?>
			</div>
			<?php
		}

        Utility::go ('categories.php'.$_POST['return_query']);

	} else {

		$tree->getCategory();

		$category = $tree->getField('category');
		$image = $tree->getField('image');
		$category_id = $tree->getField('category_id');
		$image_status = $tree->getField('image_status');

		$pathway = $tree->pathway($_GET['pcid']);
		unset ($pathway[$category_id]);
		$parent = end($pathway);

		$parent_id = $parent['category_id'];

		$base_dir = "/shop/images/";

		if ($image_status == 1) {
            // Set picture directory.
            $img = Utility::getShopImage($base_dir.$image);
            $img_file =  $img;
		} else {
			$img_file = "image.php?bg=FFFFFF&tc=FF0000&txt=IMAGE OFF";
		}

		// get all decendents
		$nopics = TRUE;

		foreach ($tree->getDecendants() as $row) {

			$img = array();
			$query = "SELECT image, image_status FROM products WHERE category_id={$row['category_id']}";

			$result = mysql_query($query);

			while ($rows = mysql_fetch_array($result,MYSQL_NUM)) {
				if ($rows[1] == 1 && is_file($_SERVER['DOCUMENT_ROOT']."/shop/images/".$rows[0])) {
					$img[] = "/shop/images/".$rows[0];
				}
			}

			if (!empty ($img)) $nopics = FALSE;

			$img_dir[$row['category']] = $img;

		}

		if ($nopics == TRUE) {

			$img_dir = "<p style=\"border:2px dashed red;background-color:white;color:red;font-variant:small-caps;font-weight:bold;\"><img src=\"/admin/images/actionwarning.png\" style=\"vertical-align:middle;\" /> <span style=\"vertical-align:middle;\">There are no pictures avaliable</span></p>";

		}
		/*
		// find depth if top set $top to category_id else 0;
		foreach ($tree->getTree() as $row) {
			// find depth if top set $top to category_id else 0;
			if ($row['category_id'] == $category_id) {
				if ($row['depth'] == 0) {
					$parent_id = 0;
					$selected = "selected=\"selected\"";
				} else {
					$selected = NULL;
				}
			}
		}
		*/
		?>
		<div class="box">
		<table cellspacing="2" cellpadding="2">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<tr><td colspan="2" align="center" style="border:2px dashed red;background-color:white;"><img src="/admin/images/actionwarning.png" style="vertical-align:middle;" /><span style="vertical-align:middle;font-weight:bold;">Changing this will affect how your products are categorized</span></td></tr>

		<tr><td align="right"><b>Category</b></td><td><input type="text" name="category" value="<?=$category?>" maxlength="60" size="20" />

		<tr><td align="right"><b>Parent</b></td><td><?=$parent['category']?>
		<?php
		/*
		$r = "<select name=\"parent\" class=\"inputbox\" size=\"10\">";
		$r .= "<option value=\"0\" $selected>Top</option>";
		foreach ($tree->getTree() as $row) {
			$r .= "<option value=\"{$row['category_id']}\"";
			if ($parent_id == $row['category_id']) $r .= "selected=\"selected\"";
			$r .=">";
			$r .= str_repeat('&nbsp;&nbsp;',($row['depth'] + 1)).$row['category']."\n";
			$r .= "</option>";
		}
		$r .= "</select>";
		print $r;
		*/
		?>

		<input type="hidden" name="old_category" value="<?=$category?>" />

		<input type="hidden" name="old_parent" value="<?=$parent_id?>" />
		</td></tr>

		<tr><td align="right"><b>Image</b></td><td><img src="<?=$img_file;?>" /></td></tr>

		<tr><td align="right"><b>Image Status</b></td><td>
			<span class="bold">
			<p> On: <input type="radio" name="image_status" value="1" <?php if ($image_status == 1) print "checked=\"checked\"";?> /> Off: <input type="radio" name="image_status" value="0" <?php if ($image_status == 0) print "checked=\"checked\"";?>/></p>
			</span>
		</td></tr>

		<tr><td align="center" colspan="2">
			<?php
			if ($nopics == FALSE) {
			?>
				<select name="image">
				<option value="nopic">No Picture</option>
				<?php

				foreach ($img_dir as $categories => $images) {

					print "<optgroup label=\"$categories\">";

					foreach ($images as $img_num => $img_loc) {

						$img = explode ("/", $img_loc);
						$c = count ($img) - 1;

						print "<option value=\""./*$img_dir_path[$categories].*/"{$img[$c]}\" ";

						if (/*$img_dir_path[$categories].*/$img[$c] == $image) {

							print "selected=\"selected\"";

						}

						print ">{$img[$c]}</option>";
					}

					print "</optgroup>";
				}
				?>
				</select>
			<?php
			} else {
				print $img_dir;
				print "<input type=\"hidden\" name=\"image\" value=\"nopic\" />";
			}
			?>
		</td></tr>
		<input type="hidden" name="pcid" value="<?=$_GET['pcid']?>" />
		<input type="hidden" name="return_query" value="?s=<?=$_GET['s']?>&np=<?=$_GET['np']?>" />
		<tr>
			<td colspan="2">
				<table>
					<tr>
						<td  align="center">
							<input type="submit" name="submit" value="Cancel" />
						</td>
						<td  align="center">
							<input type="submit" name="submit" value="Change" />
						</td>
					</tr>
				</table>
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
