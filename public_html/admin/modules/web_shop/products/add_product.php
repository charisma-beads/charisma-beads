<?php // webshop_add_product.php (administration side) Friday, 8 April 2005
// This is the webshop add_product page for the admin side of the site.

// Set the page title.
$page_title = "Add Product";

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

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);

	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
	
	require_once ('menu_links.php');
	
	print "</td><td valign=\"top\">";
	
	if (isset($_POST['submit'])) { // Handle the form.
	
		// Validate the product name, image, product line, size, price, and description.
				
		// [status] => 1 check for status

		if (isset ($_POST['enabled'])) {
			$e = 1;
		} else {
			$e = 0;
		}
		
		// Check for a product name.
		if (!empty($_POST['product_name'])) {
			$pn = escape_data($_POST['product_name']);
			$pi = strtolower (str_replace (" ", "_", $pn)) . ".jpg";
		} else {
			$pn = FALSE;
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Name!</p></span>\r\n";
		}
		
		// Check for group price.
		if (is_numeric ($_POST['group_id'])) {

			$group_id = $_POST['group_id'];
			
			if ($group_id > 0) {
				$query = "
					SELECT price 
					FROM product_group_price
					WHERE group_id=$group_id
					";
				$result = mysql_query ($query);
				$_POST['price'] = mysql_result ($result, 0, 'price');
			}

		} else {

			$group_id = FALSE;
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please select a valid price group!</p></span>\r\n";

		}
		
		// Check for a price.
		if (is_numeric($_POST['price'])) {
			$p = number_format($_POST['price'], 2);
		} else {
			$p = number_format(0,2);
			//print "<span class=\"smcap\"><p class=\"fail\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" />Please Enter the Product's price!</p></span>\r\n";
		}
		
		if (is_numeric($_POST['quantity'])) {
			$qty = $_POST['quantity'];
		} else {
			$qty = false;
		}
	
		// Check for a description.
		if (!empty($_POST['short_description'])) {
			$sd = escape_data($_POST['short_description']);
		} else {
			$sd = FALSE;
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a short description!</p></span>\r\n";
		}
		
		if ($_POST['use_short'] == "on") {
			
			$d = $sd;
			
		} else {
			if (!empty($_POST['description'])) {
				$d = escape_data($_POST['description']);
			} else {
				$d = '<i>No description available</i>';
			}
		}
		
		// Validate the product Category.
		if (is_numeric ($_POST['product_category'])) {

			$pc = escape_data ($_POST['product_category']);

		} else {

			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Valid Category!</p></span>\r\n";
			$pc = FALSE;

		}
	
		// Validate the product size.
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
				print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter a Product Line!</p></span>\r\n";
			}
		
		} elseif (($_POST['product_size'] == 's_existing') && ($_POST['s_existing'] > 0)) {
			$s = $_POST['s_existing'];
		} else {
			$s = FALSE;
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Enter or select a product size!</p></span>\r\n";
		}
		
		// Validate the product weight.
		if ($_POST['product_postunit'] == 'new') {
	
			// If it's a new product weight, add the product weight to the database.
			$weight = $_POST['weight'];
		
			if (!empty($_POST['weight'])) {
				
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
		
		// Validate image

		// [upload_image] => 1
		// [image_status] => 1

		$product_img_dir = "/shop/images/";
		/*
		$category = NULL;

		foreach ($tree->pathway($pc) as $id => $path) {

			$category .= "/" . strtolower (str_replace (" ", "_", str_replace ("/", "_",$path['category'])));

		}
		*/
		$img_dir = $_SERVER['DOCUMENT_ROOT'] . $product_img_dir /*. $category*/;
		
		if ($_POST['upload_image'] == 1) {

			if (is_uploaded_file ($_FILES['image']['tmp_name'])) {	

				if (move_uploaded_file ($_FILES['image']['tmp_name'], $img_dir.$_FILES['image']['name'])) {

					print "<span class=\"smcap\"><p class=\"pass\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionok.png\" />The image has been uploaded!</p></span>\r\n";

					$i = $_FILES['image']['name'];
					rename ($img_dir.$i, $img_dir.$pi);
					chmod($img_dir.$pi, 0644);

					// Resize the image.
					require_once ('../functions/image_resize.php');
					$img_source = $img_dir.$pi;
					$save_to = $img_dir.$pi;
					$quality = 100;
					$width = 98;
					//$str = chr(169) . $merchant_name . " " . date ("Y");
					$str = "";
					easyResize($img_source, $save_to, $quality, $width, $str);

					$image = "$pi";

				} else {

					$image = "$pi";
					print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />The image could not be uploaded!</p></span>\r\n";
				}
			} else {
				$image = "$pi";
				print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />The image could not be uploaded!</p></span>\r\n";
			}
		} else {
			$image = "$pi";
		}
		
		if ($pn && $p && $pc && $sd && $qty) {
	
			// Add the product to the database.
			$query = "INSERT INTO products (category_id, size_id, tax_code_id, postunit_id, multilevel_id, group_id, product_name, price, description, short_description, image, quantity, date_entered, multiprice, enabled, vat_inc) VALUES ($pc, $s, {$_POST['tax_code_id']}, $w, 0, $group_id, '$pn', $p, '$d', '$sd', '$image', $qty, NOW(), 0, $e, {$_POST['inc_vat']})";
			
			$result = mysql_query ($query)
                or $errors->sqlErrorHandler(mysql_errno(), mysql_error(), $query);

			if ($result) { // Worked.
				print "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" />The Product has been added.</p></span>";
				print '<form name="NewProduct" action="add_product.php" method="post"><input type="submit" value="New Product"></form>';
			} else { // If query didn't run OK.
				print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Your Submission could not be processed due to a system error.</p></span>";
			}
		
		} else { // Failed a test.
			print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please click back and try again.</p></span>";
			print '<form name="Back" action="add_product.php" method="post"><input type="submit" value="Back"></form>';
		}
	
	} else { // Display the form.
	?>
	
	<form enctype="multipart/form-data" action="add_product.php" method="post">
	
	<fieldset>
	<legend>Details</legend>
	<input type="hidden" name="MAX_FILE_SIZE" value="524288">
	<!-- Product Status -->
	<p><b>Enabled:</b> 
	<input type="checkbox" name="enabled" value="1" />
	</p>
	<!-- Product Name -->
	<p><b>Product Name/Number:</b> <input type="text" name="product_name" size="30" maxlength="60" /></p>
	
	<!-- Product Category -->
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
	<!-- Product Description -->
	<p><b>Short Description:</b> <input type="text" name="short_description" size="30" maxlength="100" /></p>
	<p><b>Use Short Description for Description:</b>
	<input type="checkbox" id="use_short" name="use_short" /> </p>
			
	<span id="d_toggle"><p><b>Description:</b>&nbsp;<b>(Plain Text:<input type="checkbox" id="plain_text" />)</b> </p><p><textarea id="description" name="description" cols="40" rows="5"></textarea></p></span>
	</fieldset>
			
	<fieldset>
	<legend>Price</legend>
	<!-- Product Size -->
	<p><b>Product Size:</b>
	
	<span style="display:block">Existing <input type="radio" name="product_size" value="s_existing" checked="checked" onclick="show(document.getElementById('ExistingSize'));hide(document.getElementById('NewSize'));" /> New <input type="radio" name="product_size" value="new" onclick="show(document.getElementById('NewSize'));hide(document.getElementById('ExistingSize'));" /></span></p>
	
	<span id="ExistingSize">
	<p>
	<select name="s_existing"><option>Select One</option>
	<?php // Retrieve all the product sizes and add to the pull down menu.
	$query = "SELECT size_id, size FROM product_size ORDER BY size ASC";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		echo "<option value=\"{$row['size_id']}\">{$row['size']}</option>\r\n";
	}
	?>
	</select>
	</p>
	</span>
		
	<span id="NewSize" style="display:none;" >
	<p>
	Size Name: <input type="text" name="size" size="20" maxlength="30" />
	</p>
	</span>
			
	<!-- Product Weight -->
	<p><b>Product Weight:</b>
	<span style="display:block">Existing <input type="radio" name="product_postunit" value="w_existing" checked="checked" onclick="show(document.getElementById('ExistingWeight'));hide(document.getElementById('NewWeight'));" /> New <input type="radio" name="product_postunit" value="new" onclick="show(document.getElementById('NewWeight'));hide(document.getElementById('ExistingWeight'));" /></span>
	</p>
	
	<span id="ExistingWeight">
	<p>
	<select name="w_existing"><option>Select One</option>
	<?php // Retrieve all the product sizes and add to the pull down menu.
	$query = "SELECT postunit_id, postunit FROM product_postunit ORDER BY postunit ASC";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		echo "<option value=\"{$row['postunit_id']}\">{$row['postunit']}</option>\r\n";
	}
	?>
	</select>
	</p>
	</span>
	
	<span id="NewWeight" style="display:none;" > 
	<p>
	Weight (gms): <input type="text" name="weight" size="5" maxlength="5" />
	</p>
	</span>
	</fieldset>
			
	<fieldset>
	<legend>Attributes</legend>
	<!-- Group Price -->
	<?php
	// Retrieve all the groups and add to the pull down menu.
	$query = "
		SELECT group_id, product_group, price 
		FROM product_group_price
	";
	$result = mysql_query ($query);
	$num_rows = mysql_num_rows($result);
	print "<p><b>Price Group:</b>";
	
	if ($num_rows > 0) {
		
		print "<select id=\"group_price\" name=\"group_id\">";
		print "<option value=\"0\">None</option>";
																
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			print "<option value=\"{$row['group_id']}\">{$row['product_group']}&nbsp;{$row['price']}</option>\r\n";
		}
		
		print "</select>";
	} else {
		print "&nbsp;<span style=\"color:red\">No groups aviliable</span>";
		print "<input type=\"hidden\" name=\"group_id\" value=\"0\" />";
	}
	
	print "</p>";
	
	if ($StockControl) {
	?>
    <p>
	<!-- Stock Control -->
		<b>Stock Control:</b>
		<span style="display:block">Non Stock <input id='non_stock' type="radio" name="stock" value="non_stock" checked="checked" onclick="hide(document.getElementById('Stock'));document.getElementById('quantity').value = -1" /> Stock <input id="stock" type="radio" name="stock" value="stock" onclick="show(document.getElementById('Stock'));document.getElementById('quantity').value = 0;" /></span>
		
		<span id="Stock">
		<p><b>Quantity:</b> <input id="quantity" type="text" name="quantity" value="-1" size="4"/></p>
		</span>
	</p>
	<?php
	} else {
		echo "<input type=\"hidden\" name=\"quantity\" value=\"-1\" />";
	}
	?>
	<!-- Product Price -->
	<p><b>Price:</b> <input id="price" type="text" name="price" size="10" maxlength="10" />
	<br /><small>Do not include the currency sign or commas.</small><br />
	<?php
	if ($VatState == 1) {
		?>	
		<b>Including Tax:</b> <input type="radio" name="inc_vat" value="1" checked="checked" />
		<b>Excluding Tax:</b> <input type="radio" name="inc_vat" value="0" />
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
	$result = mysql_query ($query);
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
		
		if ($row['tax_code'] == "S") {
			$tax_select = 'selected="selected"';
		} else {
			$tax_select = NULL;
		}
		
		echo "<option $tax_select value=\"{$row['tax_code_id']}\">{$row['tax_code']} - {$row['description']} - {$row['tax_rate']}%</option>\r\n";
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
	</fieldset>
			
	<fieldset>
	<legend>Image</legend>
	<!-- Product Image -->
		<p><b>Upload Image:</b> 
		<input type="checkbox" id="upload_image" name="upload_image" value="1" /></p>
		<span id="FileUpload">
		<p><b>Image:</b> 
		<input type="file" name="image" /></p>
		</span>
																	
		<!-- Image Status -->
		<p><b>Image Status:</b><br />
		<span>On: </span><input type="radio" checked="checked" name="image_status" value="1" />
		<span>Off: </span><input type="radio" name="image_status" value="0" /></p>
	</fieldset>
	
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>
	</form>
			
	<script>
		window.addEvent("domready", function(){
			
			$('group_price').addEvent('change', function() {
				if ($('group_price').getValue() > 0) {
					$('price').disabled = true;
				} else {
					$('price').disabled = false;
				}
			});
			
			if ($('Stock')) {
				if ($('non_stock').checked = true) hide($('Stock'));
			}
	
			$('plain_text').addEvent('change', function() {
				
				var id = 'description';
	
				if (!tinyMCE.getInstanceById(id)) {
					tinyMCE.execCommand('mceAddControl', false, id);
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, id);
					var query = 'txt=' + $(id).value;
					new Ajax('plain_text.php', {
						method: 'post',
  						data: query, // save list string.
						onSuccess: function(response) {
							$(id).value = response;
						}
					}).request();
				}
	
			});
	
			$('use_short').addEvent('change', function() {
				
				var id = 'description';
	
				if (!tinyMCE.getInstanceById(id)) {
					tinyMCE.execCommand('mceAddControl', false, id);
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, id);
				}
	
				if ($('d_toggle').getStyle('display') == 'none') {
					$(id).readOnly = false;
					$('d_toggle').setStyle('display','block');
				} else {
					$(id).readOnly = true;
					$('d_toggle').setStyle('display','none');
				}
	
			});

		});
	</script>
	<?php
	} // End of condtional.
	
	print "</td></tr></table>";
	
}

mysql_close(); // Close the database connection.
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
