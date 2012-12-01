<?php
// view_order.php Tuesday, 3 May 2005
// This is the edit product page for admin.

// Set the page title.
$page_title = "Edit Product";

$custom_headtags = '
	<!-- TinyMCE -->
	<script type="text/javascript" src="/admin/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "textareas",
 			theme : "advanced",
 			plugins : "inlinepopups",
 			inlinepopups_skin : "clearlooks2",
 			dialog_type : "modal",

 			theme_advanced_buttons1: "formatselect,fontselect,fontsizeselect,help",
 			theme_advanced_buttons2 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
			 theme_advanced_buttons3 : "bullist,numlist,|,outdent,indent,|,undo,redo",
 			theme_advanced_buttons4 : "removeformat,|,sub,sup"
		});
	</script>
	<!-- /TinyMCE -->
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/webshop_config.php');
include_once ('../functions/image_resize.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	if (isset($_GET['pid']) || isset($_POST['pid'])) {
		if (isset($_GET['pid'])) {
			$pid = $_GET['pid'];

		} else {
			$pid = $_POST['pid'];

		}

	}

	// Get the product details.
	$query = "
		SELECT
			product_id,
			category_id,
   			size,
			product_name,
			price,
			p.description,
			short_description,
			image,
			p.image_status,
			quantity,
			tax_code,
			postunit,
			vat_inc,
			postage
		FROM
			products AS p,
			product_size AS ps,
			tax_codes AS tc,
			tax_rates AS tr,
			product_postunit AS w
		WHERE p.product_id=$pid
		AND p.size_id=ps.size_id
		AND p.tax_code_id=tc.tax_code_id
		AND tc.tax_rate_id=tr.tax_rate_id
		AND p.postunit_id=w.postunit_id
		";
	$result = mysql_query ($query);

	$product_id = mysql_result ($result, 0, 'product_id');
	$category_id = mysql_result ($result, 0, 'category_id');
	$size = mysql_result ($result, 0, 'size');
	$product_name = mysql_result ($result, 0, 'product_name');
	$price = mysql_result ($result, 0, 'price');
	$description = mysql_result ($result, 0, 'description');
	$short_description = mysql_result ($result, 0, 'short_description');
	$image = mysql_result ($result, 0, 'image');
	$image_status = mysql_result ($result, 0, 'image_status');
	$quantity = mysql_result ($result, 0, 'quantity');
	$tax_code = mysql_result ($result, 0, 'tax_code');
	$postunit = mysql_result ($result, 0, 'postunit');
	$vat_inc = mysql_result ($result, 0, 'vat_inc');
	$postage = mysql_result ($result, 0, 'postage');


	// Set Image directies

	// start tree class
	$tree = new NestedTree('product_category', $category_id, 'category', $dbc);

	$product_img_dir = "/shop/images/";
	/*
	$category = NULL;

	foreach ($tree->pathway($category_id) as $id => $path) {

		$category .= "/" . strtolower (str_replace (" ", "_", str_replace ("/", "_",$path['category'])));

	}
*/
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . $product_img_dir /*. $category*/;
	$line_img = $img_dir . $image;
	// Check that image file exists.
	$img = $product_img_dir . $image;

	if ($image_status == 1){
		// Set picture directory.
        $img = Utility::getShopImage($img);
        $img_file =  $img;
	} else {
		$img_file = "image.php?bg=FFFFFF&tc=FF0000&txt=IMAGE OFF";
	}

	print "<table border='0' width='100%'><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";

	require_once ('menu_links.php');

	print "</td><td style=\"padding-left:10px;padding-right:10px;\" valign=\"top\">";

	if (isset($_POST['submit'])) { // Handle the form.

		// Validate the product name, image, product line, size, price, and description.

		$_SESSION['error'] = NULL;
		$_SESSION['message'] = NULL;
		$update_query = array();

		// Check for a product name.

		//	[change_product_name]
    	//	[product_name]
		if ($_POST['change_product_name'] == 1) {

			if (!empty($_POST['product_name'])) {
				$pn = escape_data($_POST['product_name']);
				$pi = strtolower (str_replace (" ", "_", $pn)) . ".jpg"; // set the image name.

				$update_query['product_name'] = $pn;
				$update_query['image'] = $pi;


			} else {
				$pn = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Name!</p></span>\r\n";
			}

		} else {
			$pn = FALSE;
			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product name</p></span>";
		}

		// Check for an image.

		//[change_image] => 0
		//[image] => array (
		//		[name] =>
   		//		[type] =>
   		//		[tmp_name] =>
   		//		[error] =>
   		//		[size] =>
		//	)

		if ($_POST['change_image'] == 1) {

			if (is_uploaded_file ($_FILES['image']['tmp_name'])) {

				if (move_uploaded_file ($_FILES['image']['tmp_name'], $img_dir.$_FILES['image']['name'])) { // Now move the file over.

					if (isset($update_query['image'])) {
						$image = $update_query['image'];
					}

					$i = $_FILES['image']['name'];
					rename ($img_dir.$i, $img_dir.$image);
					chmod($img_dir.$image, 0644);

					// Resize the image.
					require_once ('../functions/image_resize.php');
					$img_source = $img_dir.$image;
					$save_to = $img_dir.$image;
					$quality = 100;
					$width = 98;
					//$str = chr(169) . $merchant_name . " " . date ("Y");
					$str = "";

					easyResize($img_source, $save_to, $quality, $width, $str);
					/*
					$dir = dir(realpath($_SERVER['DOCUMENT_ROOT'] . '/shop/cache/'));

					while (false !== ($entry = $dir->read())) {
					  	if ($entry == '.' || $entry == '..') {
							continue;
						}

						unlink($_SERVER['DOCUMENT_ROOT'] . '/shop/cache/' . $entry);
						print $_SERVER['DOCUMENT_ROOT'] . '/shop/cache/' . $entry . '<br />';
					}

					$dir->close();
					*/

					$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" />The image has been uploaded!</p></span>\r\n";

				} else { // Couldn't move the file over.

					$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />The image could not be uploaded!</p></span>\r\n";
				}

			} else {

				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />The image could not be uploaded!</p></span>\r\n";
			}

		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product image</p></span>";
		}

		// Check for a image status.

		//	[change_image_status]
    	//	[image_status]

    	if ($_POST['change_image_status'] == 1) {

			$is = escape_data($_POST['image_status']);
			$update_query['image_status'] = $is;
		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to image status</p></span>";
		}

		// Validate the product line.

		// [change_product_lines] => 0
   		// [product_lines] => pl_existing
   		// [pl_existing] => 1
   		// [product_line] =>
		// [parent] =>

		if ($_POST['change_category'] == 1) {

			if (is_numeric ($_POST['product_category'])) {

				$pcid = escape_data ($_POST['product_category']);

			} else {
				$pcid = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter or select a product Category!</p></span>\r\n";
			}

			$update_query['category_id'] = $pcid;

		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product Category</p></span>";
		}

		// Validate the product size.

		// [change_product_size] => 0
   		// [product_size] => s_existing
   		// [s_existing] => 1
   		// [size] =>
   		if ($_POST['change_product_size'] == 1) {
			if ($_POST['product_size'] == 'new') {

				// If it's a new product size, add the product size to the database.
				$size = escape_data($_POST['size']);

				if (!empty($_POST['size'])) {

					$query = "
						SELECT size_id
						FROM product_size
						WHERE size='$size'
						LIMIT 1
					";
					$result = mysql_query ($query);

					// If new insert record else use existing size_id.
					if (mysql_num_rows ($result) == 0) {
						$query = "
							INSERT INTO product_size (size_id, size)
							VALUES (NULL,'$size')
						";
						$result = mysql_query ($query); // Run the query.
						$s = mysql_insert_id(); // Get the product size ID.
					} else {

						$s = mysql_result ($result, 0, 'size_id');

					}

				} else {
					$s = FALSE;
					$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Line!</p></span>\r\n";
				}

			} elseif (($_POST['product_size'] == 's_existing') && ($_POST['s_existing'] > 0)) {
				$s = $_POST['s_existing'];

			} else {
				$s = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter or select a product size!</p></span>\r\n";
			}

			$update_query['size_id'] = $s;

		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product size</p></span>";
		}

		// Validate the product weight.

		// [change_product_postunit] => 0
   		// [product_postunit] => w_existing
   		// [w_existing] => 1
   		// [postunit] =>

		if ($_POST['change_product_postunit'] == 1) {

			if ($_POST['product_postunit'] == 'new') {

				// If it's a new product weight, add the product weight to the database.
				$weight = $_POST['postunit'];

				if (!empty($_POST['postunit'])) {

					$query = "
						SELECT postunit_id
						FROM product_postunit
						WHERE postunit=$weight
						LIMIT 1
					";
					$result = mysql_query ($query);

					// If new insert record else use existing postunit_id.
					if (mysql_num_rows ($result) == 0) {

						$query = "
							INSERT INTO product_postunit (postunit_id, postunit)
							VALUES (NULL, $weight)
						";
						$result = mysql_query ($query); // Run the query.
						$w = mysql_insert_id(); // Get the product weight ID.

					} else {

						$w = mysql_result ($result, 0, 'postunit_id');
					}
				} else {
					$w = FALSE;
					print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Weight!</p></span>\r\n";
				}

			} elseif (($_POST['product_postunit'] == 'w_existing') && ($_POST['w_existing'] > 0)) {
				$w = $_POST['w_existing'];
			} else {
				$w = FALSE;
				print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter or select a product weight!</p></span>\r\n";
			}

			$update_query['postunit_id']  = $w;

		}else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product weight</p></span>";
		}

		// Check for stock quantity.
		if ($StockControl) {
			if ($_POST['change_stock'] == 1) {

				if (is_numeric($_POST['quantity'])) {
					$qty = escape_data($_POST['quantity']);
				} else {
					$qty = false;
					$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a a valid quantity!</p></span>\r\n";
				}

				$update_query['quantity'] = $qty;

			} else {

				$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product quantity</p></span>";
			}
		}

		// Check for a price.

		//[change_price] => 0
    	//[price] => 2.70
    	//[inc_vat] => 1
    	//[tax_code_id] => 1

    	if ($_POST['change_price'] == 1) {

			if (is_numeric($_POST['price'])) {
				$pp = escape_data($_POST['price']);

			} else {
				$pp = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Price!</p></span>\r\n";
			}

			$update_query['price'] = $pp;
			$update_query['vat_inc'] = $_POST['inc_vat'];
			$update_query['tax_code_id'] = $_POST['tax_code_id'];

		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product price</p></span>";
		}

		// Check for a product description.

		if ($_POST['change_short_description'] == 1) {

			if (!empty($_POST['short_description'])) {
				$sd = escape_data($_POST['short_description']);
			} else {
				$sd = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Short Description!</p></span>\r\n";
			}

			$update_query['short_description'] = $sd;

		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to short Description</p></span>";
		}

		// [change_description] => 0
    	// [description] => Gunmetal

		if (isset($_POST['use_short']) == "on") {

			$update_query['description'] = $sd;

		} else {

			if ($_POST['change_description'] == 1) {

				if (!empty($_POST['description'])) {
					$pd = escape_data($_POST['description']);

				} else {
					$pd = FALSE;
					$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionwarning.png\" />Please Enter a Product Description!</p></span>\r\n";
				}

				$update_query['description'] = $pd;

			} else {

				$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to product description</p></span>";
			}
		}

		if ($_POST['change_postage'] == 1) {

			if (is_numeric($_POST['postage'])) {
				$ps = escape_data($_POST['postage']);

			} else {
				$ps = FALSE;
				$_SESSION['error'] .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a postage state!</p></span>\r\n";
			}

			$update_query['postage'] = $ps;


		} else {

			$_SESSION['message'] .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionwarning.png\" />No Change to postage state</p></span>";
		}

		if ($update_query) {

			$query_num = count ($update_query);
			$c = 1;

			if ($update_query > 0) {
				$query = "UPDATE products SET ";

				// assemble update query.
				foreach ($update_query as $column => $value) {
					if (is_numeric($value)) {
						$query .= "$column=$value";

					} else {
						$query .= "$column='$value'";

					}

					if ($query_num > 1 && $query_num != $c) {
						$query .= ",";
					}

					$query .= " ";
					$c++;
				}

				$query .= "WHERE product_id={$_POST['pid']}";

				// Do the query.
				if ($result = mysql_query($query)) {

					// if product name changed and if image file on server then change it's name.
					// empty image cache

					if($pn && file_exists($img_dir.$image)) {
                        print $img_dir.$image;
                        print '<br />'. $img_dir.$pi;
						rename ($img_dir.$image, $img_dir.$pi);
					}

				}
			}
		}
		//print $query;

		Utility::go ('edit_product.php?pid=' . $pid);


	} else { // Display the form.

		// Set the previous and next links.
		$query = "
			SELECT product_id, category, lft, products.category_id
			FROM products, product_category
			WHERE products.category_id=product_category.category_id
			AND discontinued=0
			ORDER BY lft ASC, product_name ASC
		";

		$result = mysql_query($query);

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$data_row[] = $row;
		}

		$c = count($data_row) - 1;
		$pr = null;
		$nr = null;

		foreach ($data_row as $key => $value) {
			if ($value['product_id'] == $product_id) {
				if ($key > 0) $pr = $data_row[$key - 1]['product_id'];
				if ($key < $c) $nr = $data_row[$key + 1]['product_id'];
			}
		}
		?>

		<table border="0" width="100%">
			<tr>
				<td width="50%">
					<?php
					if (!$page_num) {
						$page_num = "?";
					} else {
						$page_num = $page_num . "&";
					}
					if ($pr) {
						print '<a href="edit_product.php'.$page_num.'pid='.$pr.'">Previous Record</a>';
					}
					?>
				</td>
				<td width="50%" align="right">
					<?php
					if ($nr) {
						print '<a href="edit_product.php'.$page_num.'pid='.$nr.'">Next Record</a>';
					}
					?>
				</td>
			</tr>
		</table>

		<table border="0" width="100%">
			<tr>
				<td align="left" valign="top" width="45%">
					<div style="border:1px solid black; padding:3px;">
					<p style="text-align:center; background-color:skyblue; color:black; font-weight:bold;">Product Details</p>
					<p><b>Name:</b> <?=$product_name;?></p>
					<p><span><b>Image:</b></span> <img src="<?=$img_file;?>" style="vertical-align:middle;" /></p>
					<?php
					$category = NULL;
					foreach ($tree->pathway($category_id) as $id => $path) {

						$category .= " - " . $path['category'];

					}

					$category = substr($category,3);
					?>
					<p><b>Product Category:</b> <?=$category;?></p>
					<p><b>Size:</b> <?=$size;?></p>
					<p><b>Weight:</b> <?=$postunit;?> grams</p>
					<?php
					if ($StockControl) {
						if ($quantity > -1) {
							?> <p><b>Stock Control:</b> <?=$quantity?> item(s) in stock</p> <?php
						} else {
							?> <p><b>Stock Control:</b> Non Stock Item</p> <?php
						}
					}
					?>
					<p><b>Price:</b> &pound;<?=$price;?>
						<?php
						if ($VatState == 1) {
							if ($vat_inc == 0) {
								print ' <small><b>ex vat</b></small>';
							} else {
								print ' <small><b>inc vat</b></small>';
							}
						}
						?>
					</p>
					<p><b>Postage:</b>
						<?php
						if ($postage == 1) {
							print "On";
						} else {
							print "Off";
						}
						?>
					</p>
					<p><b>Short Description:</b> <?=$short_description;?></p>
					<p><b>Description:</b> <?=$description;?></p>
					</div>
					<?php
					if (isset($_SESSION['message']) || isset($_SESSION['error'])) {
					?>
					<div style="border:1px solid black; padding:3px; margin-top:10px;">
					<?=$_SESSION['message'];?>
					<?=$_SESSION['error'];?>
					</div>
					<?php
					}
					?>
				</td>

				<td width="10%">
					&nbsp;
				</td>

				<td align="left" valign="top" width="45%">
					<div style="border:1px solid black; padding:3px;">
					<form enctype="multipart/form-data" action="edit_product.php" method="post">

					<input type="hidden" name="MAX_FILE_SIZE" value="524288">

					<p style="text-align:center; background-color:skyblue; color:black; font-weight:bold;" >Fill out the form to edit a product</p>

					<!-- Product Name -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Product Name: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_product_name" value="1" onclick="show(document.getElementById('Name'));" /> No: <input type="radio" name="change_product_name" value="0" checked="checked" onclick="hide(document.getElementById('Name'));" /></span></p>

					<span id="Name" style="display:none;" >
					<p><b>Product Name/Number:</b><br /><input type="text" name="product_name" size="30" maxlength="60" value="" /></p>
					</span>
					</div>

					<!-- Product Image -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Image: <span class="bold" style="display:block;"> Yes: <input type="radio" name="change_image" value="1" onclick="show(document.getElementById('Image'));" /> No: <input type="radio" name="change_image" value="0" checked="checked" onclick="hide(document.getElementById('Image'));" /></span></p>

					<span id="Image" style="display:none;" >
					<p><b>Upload New Image File:</b><br /><input type="file" name="image" /></p>
					</span>
					</div>

					<!-- Image Status -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Image Status: <span class="bold" style="display:block;"> Yes: <input type="radio" name="change_image_status" value="1" onclick="show(document.getElementById('Image_Status'));" /> No: <input type="radio" name="change_image_status" value="0" checked="checked" onclick="hide(document.getElementById('Image_Status'));" /></span></p>

					<span id="Image_Status" style="display:none;" >
					<p><span class="bold" style="display:block;"> On: <input type="radio" name="image_status" value="1" <?php if ($image_status == 1) print "checked=\"checked\"";?>/> Off: <input type="radio" name="image_status" value="0" <?php if ($image_status == 0) print "checked=\"checked\"";?>/></span></p>
					</span>
					</div>

					<!-- Product Line -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Category: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_category" value="1" onclick="show(document.getElementById('Category'));" /> No: <input type="radio" name="change_category" value="0" checked="checked" onclick="hide(document.getElementById('Category'));" /></span></p>

					<span id="Category" style="display:none;" >
					<!--
					<p><b>Product Category:</b>

					<span style="display:block">Existing <input type="radio" name="product_category" value="pc_existing" checked="checked" onclick="show(document.getElementById('ExistingCategory'));hide(document.getElementById('NewCategory'));" /> New <input type="radio" name="product_category" value="new" onclick="show(document.getElementById('NewCategory'));hide(document.getElementById('ExistingCategory'));" /></span></p>
					-->
					<!--
					<span id="ExistingCategory">
					-->
					<!-- Product Category -->
					<p><b>Product Category:</b>
					<select name="product_category"><option>Select One</option>
					<?php // Retrieve all the product lines and add to the pull down menu.

					foreach ($tree->getTree() as $row) {
						print "<option value=\"{$row['category_id']}\">".str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth']));
						if ($row['depth'] > 0) print "&bull;&nbsp;";
						print "{$row['category']}</option>\r\n";
					}
					?>
					</select>
					</p>
					<!--
					</span>

					<span id="NewCategory" style="display:none;">
					<p>
					<b></b>Category Name: <input type="text" name="pc_new" size="20" maxlength="30" />
					</p>
					</span>
					-->
					</span>
					</div>

					<!-- Product Size -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Product Size: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_product_size" value="1" onclick="show(document.getElementById('Size'));" /> No: <input type="radio" name="change_product_size" value="0" checked="checked" onclick="hide(document.getElementById('Size'));" /></span></p>

					<span id="Size" style="display:none;" >
					<p><b>Product Size:</b>
					<span style="display:block">Existing <input type="radio" name="product_size" value="s_existing" checked="checked" onclick="show(document.getElementById('ExistingSize'));hide(document.getElementById('NewSize'));" /> New <input type="radio" name="product_size" value="new" onclick="show(document.getElementById('NewSize'));hide(document.getElementById('ExistingSize'));" /></span></p>

					<span id="ExistingSize">
					<p><b>Size:</b><br />
					<select name="s_existing"><option>Select One</option>
					<?php // Retrieve all the product sizes and add to the pull down menu.
					$query = "SELECT size_id, size FROM product_size ORDER BY size ASC";
					$result = @mysql_query ($query);
					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
						echo "<option value=\"{$row['size_id']}\"";

						if ($row['size'] == $size) {

							echo 'selected="selected"';
						}

					echo ">{$row['size']}</option>\r\n";
					}
					?>
					</select>
					</p>
					</span>

					<span id="NewSize" style="display:none;" >
					<p><b>Size:</b><br /><input type="text" name="size" size="20" maxlength="30" />
					</p>
					</span>
					</span>
					</div>

					<!-- Product Weight -->
					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Product Weight: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_product_postunit" value="1" onclick="show(document.getElementById('Weight'));" /> No: <input type="radio" name="change_product_postunit" value="0" checked="checked" onclick="hide(document.getElementById('Weight'));" /></span></p>

					<span id="Weight" style="display:none;" >
					<p><b>Product Weight:</b>
					<span style="display:block">Existing <input type="radio" name="product_postunit" value="w_existing" checked="checked" onclick="show(document.getElementById('ExistingWeight'));hide(document.getElementById('NewWeight'));" /> New <input type="radio" name="product_postunit" value="new" onclick="show(document.getElementById('NewWeight'));hide(document.getElementById('ExistingWeight'));" /></span></p>

					<span id="ExistingWeight">
					<p><b>Size:</b><br />
					<select name="w_existing"><option>Select One</option>
					<?php // Retrieve all the product sizes and add to the pull down menu.
					$query = "SELECT postunit_id, postunit FROM product_postunit ORDER BY postunit ASC";
					$result = mysql_query ($query);
					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
						echo "<option value=\"{$row['postunit_id']}\"";

						if ($row['postunit'] == $postunit) {

							echo 'selected="selected"';
						}

						echo " >{$row['postunit']}</option>\r\n";
					}
					?>
					</select>
					</p>
					</span>

					<span id="NewWeight" style="display:none;" >
					<p><b>Size:</b><br /><input type="text" name="postunit" size="20" maxlength="30" />
					</p>
					</span>
					</span>
					</div>

					<!-- Stock Control -->
					<?php
					if ($StockControl) {
					?>
					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Stock Control: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_stock" value="1" onclick="show(document.getElementById('StockControl'));" /> No: <input type="radio" name="change_stock" value="0" checked="checked" onclick="hide(document.getElementById('StockControl'));" /></span></p>

					<span id="StockControl" style="display:none;" >
						<b>Stock Control:</b>
						<span style="display:block">Non Stock <input id='non_stock' type="radio" name="stock" value="non_stock" <?php
						if ($quantity < 0) print 'checked="checked"'; ?> onclick="hide(document.getElementById('Stock'));document.getElementById('quantity').value = -1" /> Stock <input id="stock" type="radio" name="stock" value="stock" <?php
						if ($quantity >= 0) print 'checked="checked"'; ?> onclick="show(document.getElementById('Stock'));document.getElementById('quantity').value = <?=$quantity?>;" /></span>

						<span id="Stock">
						<p><b>Quantity:</b> <input id="quantity" type="text" name="quantity" value="<?=$quantity?>" size="4"/></p>
						</span>
					</span>
					</div>
					<?php } else {
						echo "<input type=\"hidden\" name=\"quantity\" value=\"-1\" />";
					} ?>

					<!-- Product Price -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Price: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_price" value="1" onclick="show(document.getElementById('Price'));" /> No: <input type="radio" name="change_price" value="0" checked="checked" onclick="hide(document.getElementById('Price'));" /></span></p>

					<span id="Price" style="display:none;" >
					<p><b>Price:</b> <input type="text" name="price" size="10" maxlength="10" value="<?=$price?>"/>
					<br /><small><b style="color:red;">Do not include the currency sign or commas.</b></small>
					<?php
						if ($VatState == 1) {
					?>
					<br /><b>Including Tax:</b> <input type="radio" name="inc_vat" value="1" <?php if ($vat_inc == 1){ print 'checked="checked"'; } ?> />
					<br /><b>Excluding Tax:</b> <input type="radio" name="inc_vat" value="0" <?php if ($vat_inc == 0){ print 'checked="checked"'; } ?> />
					<?php
						} else {
							echo "<input type=\"hidden\" name=\"inc_vat\" value=\"1\" />";
						}
					?>
					</p>

					<!-- Product Tax -->
					<?php
						if ($VatState == 1) {
					?>
					<p><b>Sales Tax Code:</b>
					<select name="tax_code_id"><option>Select One</option>
					<?php // Retrieve all the tax codes and add to the pull down menu.
						$query = "SELECT tax_code_id, tax_code, description, tax_rate FROM tax_codes, tax_rates WHERE tax_codes.tax_rate_id=tax_rates.tax_rate_id";
						$result = @mysql_query ($query);
						while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
							if ($row['tax_rate'] > 0) {
								$row['tax_rate'] = substr ($row['tax_rate'], 2);
								$row['tax_rate'] = substr ($row['tax_rate'], 0, 2) . "." . substr ($row['tax_rate'], -1);
								if (substr ($row['tax_rate'], 0, 1) == 0) {
									$row['tax_rate'] = substr ($row['tax_rate'], 1);
								}

								$row['tax_rate'] = number_format ($row['tax_rate'], 2);

							} else {
								$row['tax_rate'] = number_format ($row['tax_rate'], 2);
							}

							echo "<option value=\"{$row['tax_code_id']}\"";

							if ($row['tax_code'] == $tax_code) {

								echo 'selected="selected"';
							}

							echo " >{$row['tax_code']} - {$row['description']} - {$row['tax_rate']}%</option>\r\n";
						}
					?>
					</select>
					<?php
						} else {
							$query = "SELECT tax_code_id FROM tax_codes WHERE tax_code='N'";
							$result = mysql_query ($query);
							$row = mysql_fetch_array ($result, MYSQL_ASSOC);
							echo "<input type=\"hidden\" name=\"tax_code_id\" value=\"{$row['tax_code_id']}\" />";
						}
					?>
					</p>
					</span>
					</div>

					<!-- Postage State -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Postage State: <span class="bold" style="display:block;"> Yes: <input type="radio" name="change_postage" value="1" onclick="show(document.getElementById('Postage'));" /> No: <input type="radio" name="change_postage" value="0" checked="checked" onclick="hide(document.getElementById('Postage'));" /></span></p>

					<span id="Postage" style="display:none;" >
					<p><span class="bold" style="display:block;"> On: <input type="radio" name="postage" value="1" <?php if ($postage == 1) print "checked=\"checked\"";?>/> Off: <input type="radio" name="postage" value="0" <?php if ($postage == 0) print "checked=\"checked\"";?>/></span></p>
					</span>
					</div>

					<!-- Product Description -->

					<!-- Short Description -->

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Short Description: <span class="bold" style="display:block"> Yes: <input type="radio" name="change_short_description" value="1" onclick="show(document.getElementById('short_descript'));" /> No: <input type="radio" name="change_short_description" value="0" checked="checked" onclick="hide(document.getElementById('short_descript'));" /></span></p>

					<span id="short_descript" style="display:none;" >
					<p><b>Short Description:</b><br /><input type="text" name="short_description" size="30" maxlength="100" value="<?=$short_description?>" /></p>
					<p><b>Use Short Description for Description:</b>
					<input type="checkbox" id="use_short" name="use_short" /> </p>
					</span>
					</div>

					<div style="border:1px dashed black; padding:3px; margin:2px">
					<p class="bold">Change Description: <span class="bold" style="display:block" > Yes: <input type="radio" name="change_description" value="1" onclick="show(document.getElementById('prod_descript'));" /> No: <input type="radio" name="change_description" value="0" checked="checked" onclick="hide(document.getElementById('prod_descript'));" /></span></p>

					<span id="prod_descript" style="display:none;" >
					<p><b>Description:<b> <textarea name="description" cols="40" rows="5"><?=$description?></textarea></p>
					</span>
					</div>
					<input type="hidden" name="pid" value="<?=$pid;?>" />
					<div align="center"><input type="submit" name="submit" value="Submit" /></div>

					</form>
					</div>
				</td>
			</tr>
		</table>
		<script>
			if ($('Stock')) {
				if ($('non_stock').checked = true && $('quantity').value < 0) hide($('Stock'));
			}
		</script>
	<?php
	unset ($_SESSION['message'], $_SESSION['error']);
	} // End of condtional.

	print "</td></tr></table>";

}

mysql_close(); // Close the database connection.
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
?>
