<?php // catalogue.php Tuesday, 3 May 2005
// This is the Browse Catalogue page for the site.

// Set the page title.
// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

if (isset($ident)) {
	$pcid = Utility::get_pcid($ident);
} elseif (isset($_GET['pcid'])) {
	$pcid = $_GET['pcid'];
}

// start tree class
$tree = new NestedTree('product_category', NULL, 'category', $dbc);

// Set the page title.
if (isset ($pcid)) {
	
	$page_title = 'Shop ';
	$pathway = $tree->pathway($pcid);
	
	if (count($pathway) > 0) {
					
		foreach ($pathway as $id => $path) {
			$page_title .= $path['category'] . " - ";
		}
	
	}
	
	$page_title = substr($page_title, 0, -3);
	
} else {
	$page_title = "Shop Front";
}
 
if ($cart->getNumCartItems() > 0) {
	$display_links = "";
} else {
	$display_links = "display:none;";
}

if ($ShopAlert) {
	$content .= '<div style="width:100%;text-align:center;"><h3 style="color:red;text-align:center;width:70%;margin-left:auto;margin-right:auto;">'.$ShopAlertText.'</h3></div>';
}

$content .= "
	<table id=\"shopping_links\" style=\"margin-left:auto;margin-right:auto;$display_links\">
	<tr>
	<td class=\"button\"><a class=\"checkout\" href=\"checkout.php\" >Check Out</a></td>
	<td class=\"button\"><a class=\"view_cart\" href=\"cart.php?action=view";
	$content .= "\" >View Cart</a></td>
	<td class=\"button\"><a class=\"empty_cart\" href=\"cart.php?action=empty";
	$content .= "\" >Empty Cart</a></td>
	</tr>
	</table>
";

// Display Serach Box.
// set id for search if one.
if (isset($pcid))
{
	$search_id = $pcid;
} else {
	$search_id = 0;
}

$content .= '
	<div id="searchBox">
		<form id="searchForm">
			<b>Product Search:</b><input type="text" id="searchQuery" value="" /><br />
			<b>any keywords:</b><input type="radio" name="search_type" id="search_all" value="part" checked="checked" />
			<b>part of phrase:</b><input type="radio" name="search_type" id="search_part" value="part" />
			<b>exact phrase:</b><input type="radio" name="search_type" id="search_exact" value="exact" />
			<input type="hidden" id="search_id" value="'.$search_id.'" />
			<input type="submit" id="submit" value="Search" class="button" />
			<p style="font-weight:bold;font-size:12px;margin-top:0px;">use product number or keyword</p>
		</form>
	</div>
';

$start = 0;

$display = 3;

if (isset($pcid))
{
	
	$tree->setId($pcid);
	
	//unset ($pathway[$_GET['pcid']]);
	
	if (count($pathway) > 0)
    {
		
		$content .= "<span style=\"text-align:left;\"><a href=\"/shop\" class=\"Tips\" title=\"Shop Tip\" rel=\"Click here to goto the shop front\">Shop Front</a></span>";
		
		foreach ($pathway as $id => $path)
        {
			$content .= "<span style=\"text-align:left;\">&nbsp;::&nbsp;";
			
			if ($pcid != $path['category_id'])
            {
				$content .= "<a href=\"/shop/{$path['ident']}\" class=\"Tips\" title=\"Shop Tip\" rel=\"Click here to goto the {$path['category']} category\">{$path['category']}</a>";
			}
            else
            {
				$content .= $path['category'];
			}
		
			$content .= "</span>";
		
		}
		
	}
	
	$content .= "<table  border=\"0\" cellpadding=\"30\" cellspacing=\"0\" style=\"margin-left:auto; margin-right:auto; text-align:center;\">"; // start table
			
	$row = $tree->getDecendants(TRUE);
	
	if ($row) {
		foreach ($row AS $key => $value) {
			if ($value['enabled'] == 0 || $value['discontinued'] == 1) {
				unset ($row[$key]);
			}
		}
	}
	
	$num_rows = ceil(count($row)/$display);
	
	for ($n = 1; $n <= $num_rows; $n++) {
		
		$content .= "<tr>";
		
		for ($d = $start; $d < ($display + $start); $d++) {
			
			$content .= "<td valign=\"bottom\">";
			
			if (isset($row[$d])) {
			
				if ($row[$d]['image_status'] == 1) {
					// Set picture directory.
					$product_img_dir = "/shop/images/";
				
					$img = $product_img_dir.$row[$d]['image'];
                    $img = Utility::getShopImage($img);
			
					$content .= "<p style=\"margin-bottom:0px;\"><a href=\"/shop/{$row[$d]['ident']}\"><img src=\"$img\" style=\"border: 3px double #AFA582;\" /></a></p>";
				}
				
				$content .= "<table align=\"center\"><tr><td class=\"button\"><a href=\"/shop/{$row[$d]['ident']}\">{$row[$d]['category']}</a></td></tr></table>";
				
			}
				
			$content .= "</td>";
		}
			
		$content .= "</tr>";
		$start = $start + $display;
		
	}
		
	$content .= "</table>"; // end table
	
	define ('PRODUCTS', 1);
	
	$content .= "<div id=\"productList\">";
	require_once ('products.php');
	$content .= "</div>";
	
} elseif ($tree->numTree() > 0) {
	
	$content .= "<table  border=\"0\" cellpadding=\"30\" cellspacing=\"0\" style=\"margin-left:auto; margin-right:auto; text-align:center;\">"; // start table
	
	$row = $tree->getTree();
	foreach ($row as $key => $value) {
		if ($value['depth'] != 0 || $value['enabled'] == 0 || $value['discontinued'] == 1) {
			unset ($row[$key]);
		}
	}
	
	
	foreach ($row AS $key => $value) {
		$category[$key]  = $value['lft'];
	}
	
	array_multisort($category, SORT_ASC, $row);
	
	$num_rows = ceil(count($row)/$display);
	
	for ($n = 1; $n <= $num_rows; $n++) {
		
		$content .= "<tr>";
			
		for ($d = $start; $d < ($display + $start); $d++) {
			
			$content .= "<td valign=\"bottom\">";
			
			if (isset($row[$d])) {
				
				if ($row[$d]['image_status'] == 1) {
				
					// Set picture directory.
					$product_img_dir = "/shop/images/";
				
					$img = $product_img_dir.$row[$d]['image'];
				
					$img = Utility::getShopImage($img);
				
					$content .= "<p style=\"margin-bottom:0px;\"><img src=\"$img\" style=\"border: 3px double #AFA582;\" /></a></p>";
				}
				
				$content .= "<table align=\"center\"><tr><td class=\"button\"><a href=\"/shop/{$row[$d]['ident']}\">{$row[$d]['category']}</a></td></tr></table>";
			} else {
				$content .= "&nbsp;";
			}
			$content .= "</td>";
			
		}
			
		$content .= "</tr>";
		$start = $start + $display;
		
	}
	$content .= "</table>"; // end table
			
	$content .= "<div id=\"productList\">";
	$content .= "</div>";
	
} else {
	
	$content .= "<h1>Online Shopping coming soon.</h1>";
}
mysql_close();

$_SESSION['queryString'] = $_SERVER['REQUEST_URI'];

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
