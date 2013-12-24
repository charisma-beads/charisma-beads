<?php // view_order.php Tuesday, 3 May 2005
// This is the view orders page for admin.

// Set the page title.
$page_title = "View Orders";

$custom_headtags = '
	<script type="text/javascript" src="/admin/js/selectBox.js"></script>
	<script type="text/javascript" src="/admin/js/mootabs.js"></script>
	<link href="/admin/css/mootabs.css" rel="stylesheet" type="text/css">
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);
	
	if (isset($_GET['oid'])) {
		$active_tab = "Tab2";
	} else {
		$active_tab = "Tab1";
	}
	

	if (isset ($_GET['cid'])) { // Come from view_customers.php.
	
		$cid = $_GET['cid'];
		
		if (isset ($_GET['oid']) && isset ($_GET['sid'])) {
			
			if ($_GET['sid'] == 4) {
				$query = "
					SELECT *
					FROM customer_orders
					WHERE customer_id={$_GET['cid']}
					AND order_id={$_GET['oid']}
				";
			
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);
				
				$cart = unserialize (stripslashes($row['cart']));
				
				foreach ($cart as $key => $value) {
					$query = "
						SELECT hits
						FROM products
						WHERE product_id = $key
					";
					$result = mysql_query($query);
					$hits = mysql_result($result,0,'hits');
					
					mysql_query("
						UPDATE products
						SET hits = $hits - {$value['Qty']}
						WHERE product_id = $key
					");
				}
				
				mysql_query ("
					UPDATE customer_orders
					SET order_status_id = {$_GET['sid']}, total = 0, shipping = 0, vat_total = 0
					WHERE customer_id={$_GET['cid']}
					AND order_id={$_GET['oid']}
				");
				
			} else {
				mysql_query ("
					UPDATE customer_orders
					SET order_status_id={$_GET['sid']}
					WHERE customer_id={$_GET['cid']}
					AND order_id={$_GET['oid']}
				");
			}
			
			$active_tab = "Tab2";
		}
		
		print "<p><a href=\"view_customers.php?cid={$_GET['cid']}\">Back to Customers View</a></p>";
		
    	$query = mysql_query ("
			SELECT order_status_id, order_status
			FROM customer_order_status
		");
		
		while ($row = mysql_fetch_array ($query, MYSQL_ASSOC)) {
			$order_status[$row['order_status_id']] = $row['order_status'];
		}
    	
    	// Make the query for the orders.
    	$query = "
			SELECT order_id AS oid, customer_id AS cid, invoice, DATE_FORMAT(order_date, '%W %D %M %Y') AS date, order_status_id 
			FROM customer_orders 
			WHERE customer_id=$cid
			ORDER BY order_date DESC 
			
		"; // LIMIT $start, $display
    	$orders = mysql_query ($query); // Run the query.
    	$num_orders = mysql_num_rows ($orders); // How many users are there?
				
		// new query for customer details.
		// Customer Invoice Address & Delivery Address.
		$CIA = "
			SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) as name, address1, address2, city, county, post_code, country, phone, email, delivery_address_id, delivery_address 
			FROM customers, countries, customer_prefix 
			WHERE customer_id=$cid
			AND customers.country_id=countries.country_id 
			AND customers.prefix_id=customer_prefix.prefix_id 
			LIMIT 1";
		$CIA = mysql_query($CIA);
		$CIA = mysql_fetch_array ($CIA, MYSQL_ASSOC);
		
		if ($CIA['delivery_address'] == "Y") {
			$CDA = "
				SELECT * 
				FROM customer_delivery_address, countries 
				WHERE customer_id=$cid 
				AND customer_delivery_address.country_id=countries.country_id 
				LIMIT 1";
			$CDA = mysql_query($CDA);
			$CDA = mysql_fetch_array ($CDA, MYSQL_ASSOC);
		}
		$i = "<table>\r\n";
		$i .= "<tr>\r\n";
		$i .= "<td valign=\"top\">\r\n";
		$i .= "<table style=\"border: 1px solid black;\">\r\n";
		$i .= "<tr><td style=\"background-color:skyblue;\">Address</td></tr>\r\n";	
		$i .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['address1']},</td></tr>\r\n";
		if ($CIA['address2']) $i .= "<tr><td>{$CIA['address2']},</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['city']},</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['county']}.</td></tr>\r\n";
		$i .= "<tr><td>{$CIA['post_code']}</td></tr>\r\n"; 
		$i .= "<tr><td>{$CIA['country']}</td></tr>\r\n";
		$i .= "<tr><td>Tel: {$CIA['phone']}</td></tr>\r\n";
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";
		$i .= "<td valign=\"top\">\r\n";
		$i .= "<table style=\"border:1px solid black;\">\r\n";
		$i .= "<tr><td style=\"background-color:skyblue; text-align:left;\">Delivery Address</td></tr>\r\n";
		if ($CIA['delivery_address'] == "Y") {
			$i .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['address1']}, {$CDA['address2']}</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['city']}, {$CDA['county']}, {$CDA['post_code']}</td></tr>\r\n";
			$i .= "<tr><td>{$CDA['country']}</td></tr>\r\n";
			$i .= "<tr><td>Tel: {$CDA['phone']}</td></tr>\r\n";
		} else {
			$i .= "<tr><td style=\"font-weight:bold;\">Same as Address</td></tr>\r\n";
		}
		$i .= "</table>\r\n";
		$i .= "</td>\r\n";
		$i .= "</tr>\r\n";
		$i .= "<tr><td colspan=\"2\">Email: {$CIA['email']}</td></tr>\r\n";
		$i .= "</table>\r\n";
		
		?>
		<div id="mooTabs" style="margin-left:auto;margin-right:auto;">
			<ul class="mootabs_title">
				<li title="Tab1">Customer Details</li>
				<li title="Tab2">Orders</li>
				<li title="Tab3">Favourite Products</li>
			</ul>
			<div id="Tab1" class="mootabs_panel">
				<?=$i?>
			</div>
			<div id="Tab2" class="mootabs_panel">
		<?php
    	if ($num_orders > 0) { // If it ran OK, display the records.

        	echo "<br />";
			
			print "<div class=\"box\">";
			
        	// Table header.
			
        	echo '<table align="center" cellspacing="2" cellpadding="2" style="width:100%;">
        	<tr bgcolor="#EEEEEE"><td align="center"><b>Order No.</b></td><td align="center"><b>Order Date</b></td><td align="center"><b>Order Status</b></td><td align="center"><b>&nbsp;</b></td></tr>';

        	// Fetch and print all the records.
			
        	$bg = '#EEEEEE'; // Set the background colour.
        	while ($row = mysql_fetch_array($orders, MYSQL_ASSOC)) {
            	$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
				echo '<tr id="oid'.$row['oid'].'" bgcolor="', $bg, '"><td align="left">', $row['invoice'], '</td><td align="left">', $row['date'], '</td>';
				
				print "<td>\n";
				
				if ($row['order_status_id'] != 4) {
					echo '<form method="get" action="view_orders.php">';
					echo '<select name="sid" class="selectBox">';
				
					foreach ($order_status as $key => $value) {
						echo '<option id="'.$row['oid'].'"  value="'.$key.'"';
						if ($row['order_status_id'] == $key) {
							echo 'selected="selected"';
						}
						echo '>'.$value.'</option>';
					}
				
					echo '</select>';
					echo '<input type="hidden" name="cid" value="'.$row['cid'].'" />';
					echo '<input type="hidden" name="oid" value="'.$row['oid'].'" />';
					echo '</form>';
				} else {
					echo '<p style="margin:0px;padding:0px;color:red;font-weight:bold;">'.$order_status[4].'</p>';
				}
				
				echo '</td>';
				
				echo '<td align="center"><a href="view_order.php?oid='. $row['oid'] . '&cid=' . $row['cid'];
				
				echo '">View</a></td></tr>';
				
        	}

        	echo '</table>'; // Close the table.
			echo '</div>';
		

    	} else { // If there are no registered users.
        	echo '<h3>There are currently no orders for this customer.</h3>';
    	}
		
		?>
			</div>
			
			<div id="Tab3" class="mootabs_panel">
			<?php
			// Get the shopping carts for this customer.
			
			$query = "
				SELECT cart
				FROM customer_orders
				WHERE customer_id=$cid
				AND order_status_id != 4
			";
			
			$result = mysql_query($query);
			$product_qty = array();
			$total_products = 0;
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows > 0) {
				while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				
					$cart = unserialize (stripslashes($row[0]));
				
					foreach ($cart as $pid => $value) {
                        if (!isset($product_qty[$pid])) {
                            $product_qty[$pid] = $value['Qty'];
                        } else {
                            $product_qty[$pid] += $value['Qty'];
                        }
						
						$total_products += $value['Qty'];
					}
				
				}
			
				// sort products by Qty.
				natsort($product_qty);
				arsort($product_qty);
			
				// Retrieve all of the information for the products in the cart.
				$query = '
					SELECT category_id, product_id, size_id, product_name, p.description
					FROM products AS p
					WHERE p.product_id IN (';
				foreach ($product_qty as $key => $value) {
					$query .= $key . ',';
				}
				$query = substr ($query, 0, -1) . ')
				';
				
				$result = mysql_query ($query);
				$products = array();
			
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$products[$row['product_id']] = $row;
				}
			
				print "<div class=\"box\">";
			
        		// Table header.
			
				echo '<table align="center" cellspacing="2" cellpadding="2">';
        		// Fetch and print all the records.
				$tot_per = null;
                $c = 0;
				$bg = '#EEEEEE'; // Set the background colour.
				foreach ($product_qty as $key => $value) {
					$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
					$c++;
					$category = NULL;
					
					foreach ($tree->pathway($products[$key]['category_id']) as $id => $path) {
						
						$category .= " - " . $path['category'];
					}
					
					$category = substr($category,3);
					
					// work out the percentage.
					$percentage = ($value / $total_products) * 100;
					$tot_per += $percentage;
					echo '<tr bgcolor="'.$bg.'">';
					echo '<td align="left" style="font-size:10px">'.$products[$key]['product_name'].'</td>';
					echo '<td style="font-size:10px">'.$category.' - '.$products[$key]['description'].'</td>';
					echo '<td align="left" style="font-size:10px"><img src="/admin/images/stat_barreend.png" alt=""><img src="/admin/images/stat_barre.png" alt="" height="14" width="'.round ($percentage).'"><img src="/admin/images/stat_barreend.png" alt="">&nbsp;'.round ($percentage, 2).'&#037;</td>';
					echo '<td style="font-size:10px">'.$value.'&nbsp;sold</td>';
					echo '</tr>';
				
				}

				echo '</table>'; // Close the table.
				
				echo '</div>';
			} else {
				echo '<h1>No products bought yet</h1>';
			}
			
			?>
			</div>
		</div>
		<script>
			window.addEvent("domready", function(){
				mooTabs1 = new mootabs("mooTabs", {width:500, height:375, activateOnLoad: '<?=$active_tab?>'});
			});
			<?php if (isset($_GET['oid'])) { ?>
			var scroll = new Fx.Scroll('Tab2', {
				wait: false,
				duration: 1500,
 				transition: Fx.Transitions.Quad.easeInOut
			});
			
			window.addEvent("load", function(){
				scroll.toElement('oid<?=$_GET['oid']?>');
			});
			<?php } ?>
		</script>
		<?php
		
		mysql_free_result($result); // Free up the resoures.
		mysql_close(); // Close the database connection.
	
	} else { // Redirect to index if didn't come from view_customers.php.
	 	
		ob_end_clean();
		header ('Location: ' . $merchant_website . '/admin/php/web_shop/index.php.');
		exit(); 
	
	}

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
