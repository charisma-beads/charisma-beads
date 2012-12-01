<?php
ob_start();
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/mysql_connect.php");
$session = Session::getInstance(86400, true);

require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/authentication.php");

if (!$authorized) {
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {

	// start tree class
	$tree = new NestedTree('product_category', NULL, 'category', $dbc);

	if (isset($_GET['tab'])) {

		switch($_GET['tab']) {

			case 'Tab1':
				?>
				<table style="background-color:skyblue">
					<tr style="background-color:#FFFFFF">
						<td colspan="2" align="center"><b>Stats</b></td>
					</tr>
					<tr style="background-color:white">
						<td><b>Total Number of Products:</b></td>
						<td>
						<?php
						$query = "SELECT product_id FROM products";
						$result = mysql_query ($query);
						$num = mysql_num_rows ($result);
						print $num;
						?>
						</td>
					</tr>
					<tr style="background-color:white">
						<td><b>Total Number of Product Categories:</b></td>
						<td>
						<?php
						print $tree->numTree();
						?>
						</td>
					</tr>
					<tr style="background-color:white">
						<td><b>Total Number of Customers:</b></td>
						<td>
						<?php
						$query = "SELECT customer_id FROM customers";
						$result = mysql_query ($query);
						$num = mysql_num_rows ($result);
						print $num;
						?>
						</td>
					</tr>
					<tr style="background-color:white">
						<td><b>Total Number of Orders:</b></td>
						<td>
						<?php
						$query = "SELECT order_id FROM customer_orders";
						$result = mysql_query ($query);
						$num = mysql_num_rows ($result);
						print $num;
						?>
						</td>
					</tr>
				</table>
				<?php
				break;
			case 'Tab2':
				?>
				<table style="background-color:skyblue;">
					<tr style="background-color:#FFFFFF">
						<td colspan="4" align="center"><b>Monthly Totals</b></td>
					</tr>
					<tr style="background-color:#EEEEEE" >
						<td align="center"><b>No of Orders</b></td>
						<td align="center"><b>Total</b></td>
						<td align="center"><b>Month</b></td>
						<td align="center"><b>Year</b></td>
					</tr>
					<?php
					$query = "
						SELECT COUNT( order_id ) AS num_orders, SUM( total ) AS total, DATE_FORMAT(order_date, '%M') AS month_long, DATE_FORMAT(order_date, '%m') AS month, DATE_FORMAT(order_date, '%Y') AS year
						FROM customer_orders
						WHERE order_status_id != 4
						GROUP BY year, month
						ORDER BY year DESC, month DESC
					";
					$result = mysql_query ($query);
					$bg = "#EEEEEE";
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE');
						print "<tr style=\"background-color:$bg\">";
						print "
							<td>{$row['num_orders']}</td>
							<td>&pound;{$row['total']}</td>
							<td>{$row['month_long']}</td>
							<td>{$row['year']}</td>
							";
						print "</tr>";
					}
					?>
				</table>
				<?php
				break;
			case 'Tab3':
				?>
				<table style="background-color:skyblue;">
					<tr style="background-color:#FFFFFF">
						<td colspan="4" align="center"><b>New Orders</b></td>
					</tr>
					<tr style="background-color:#EEEEEE">
						<td>Customer</td>
						<td>Order</td>
						<td>Status</td>
						<td>Date</td>
					</tr>
					<?php
					$query = "
						SELECT CONCAT(prefix, ' ', first_name, ' ', last_name ) AS name, invoice, order_status, DATE_FORMAT(order_date, '%D %M %Y') AS date, order_id, customers.customer_id
						FROM customers, customer_prefix, customer_orders, customer_order_status
						WHERE customer_orders.order_status_id IN (
							SELECT order_status_id
							FROM customer_order_status
							WHERE order_status != 'Cancelled'
							AND order_status != 'Dispatched'
						)
						AND customer_orders.order_status_id = customer_order_status.order_status_id
						AND customers.customer_id = customer_orders.customer_id
						AND customers.prefix_id = customer_prefix.prefix_id
						ORDER BY order_date DESC
					";
					$result = mysql_query ($query);

					$bg = "#EEEEEE";

					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

						$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE');
						print "<tr style=\"background-color:$bg\">";
						print "
							<td><a href=\"customers/view_orders.php?cid={$row['customer_id']}\">{$row['name']}</a></td>
							<td><a href=\"customers/view_order.php?cid={$row['customer_id']}&oid={$row['order_id']}\">{$row['invoice']}</a></td>
						";

						$orderQuery = "
							SELECT order_status_id, order_status
							FROM customer_order_status
						";
						$orderResult = mysql_query($orderQuery);
						print "<td>";
						print "<form id=\"order{$row['order_id']}\" action=\"index.php\" method=\"post\">";
						print "<select name=\"order_status\" onChange=\"this.form.submit()\">";
						while ($orderRow = mysql_fetch_array($orderResult, MYSQL_ASSOC)) {

							print "<option value=\"{$orderRow['order_status_id']}\" ";
							if ($row['order_status'] == $orderRow['order_status']) print "selected=\"selected\"";
							print ">{$orderRow['order_status']}</option>";

						}
						print "</select>";
						print "<input type=\"hidden\" name=\"oid\" value=\"{$row['order_id']}\" />";
						print "</form>";
						print "</td>";

						print "
							<td>{$row['date']}</td>
						";
						print "</tr>";
					}
					?>
				</table>
				<?php
				break;
			case 'Tab4':
				?>
				<table style="background-color:skyblue;">
					<tr style="background-color:#FFFFFF">
						<td colspan="3" align="center"><b>Customer Stats</b></td>
					</tr>
					<tr style="background-color:#EEEEEE" >
						<td align="center"><b>Customer</b></td>
						<td align="center"><b>No of Orders</b></td>
						<td align="center"><b>Total Spent</b></td>
					</tr>
					<?php
					$query = "
						SELECT CONCAT(prefix, ' ', first_name, ' ', last_name ) AS name, COUNT( customer_orders.customer_id ) AS num_orders, SUM( total + shipping ) AS total, customers.customer_id
						FROM customer_orders, customers, customer_prefix
						WHERE customer_orders.customer_id
						IN (
							SELECT customer_id
							FROM customers
						)
						AND customers.customer_id = customer_orders.customer_id
						AND customers.prefix_id = customer_prefix.prefix_id
						GROUP BY customer_orders.customer_id
						ORDER BY total  DESC
					";
					$result = mysql_query ($query);
					$bg = "#EEEEEE";
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE');
						print "<tr style=\"background-color:$bg\">";
						print "
							<td><a href=\"customers/view_orders.php?cid={$row['customer_id']}\">{$row['name']}</a></td>
							<td>{$row['num_orders']}</td>
							<td>&pound;{$row['total']}</td>
						";
						print "</tr>";
					}
					?>
				</table>
				<?php
				break;
			case 'Tab5':
				// Retrieve all of the information for the products hits.
				$query = '
					SELECT category_id, product_id, product_name, short_description, hits
					FROM products AS p
					WHERE hits > 0
					ORDER BY hits + 0 DESC
				';

				$result = mysql_query ($query);
				$num_products = mysql_num_rows($result);

				print "<div class=\"box\">";

        		// Table header.
				echo '<table align="center" cellspacing="2" cellpadding="2">';
        		// Fetch and print all the records.

				$bg = '#EEEEEE'; // Set the background colour.
				$tot_per = null;

				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					$category = NULL;
					foreach ($tree->pathway($row['category_id']) as $id => $path) {

						$category .= " - " . $path['category'];

					}

					$category = substr($category,3);

					$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
					// work out the percentage.
					$percentage = ($row['hits'] / $num_products) * 100;
					$tot_per += $percentage;
					echo '<tr bgcolor="'.$bg.'">';
					echo '<td align="left" style="font-size:10px">'.$row['product_name'].'</td>';
					echo '<td style="font-size:10px">'.$category.' - '.$row['short_description'].'</td>';
					echo '<td align="left" style="font-size:10px"><img src="/admin/images/stat_barreend.png" alt=""><img src="/admin/images/stat_barre.png" alt="" height="14" width="'.round ($percentage).'"><img src="/admin/images/stat_barreend.png" alt="">&nbsp;'.round ($percentage, 2).'&#037;</td>';
					echo '<td style="font-size:10px">'.$row['hits'].'&nbsp;sold</td>';
					echo '</tr>';

				}

				echo '</table>'; // Close the table.

				echo '</div>';
				break;

		}

	}

}
// Flush the buffered output to the web browser.
ob_end_flush();
?>
