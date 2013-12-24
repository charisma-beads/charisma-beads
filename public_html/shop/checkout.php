<?php // checkout.php Tuesday, 3 May 2005
// This is the Checkout page for the site.
// Checkout process 1/3.

// Set the page title and include the HTML header.
$page_title = "Checkout";

// Include configuration file for error management and such.
require_once (realpath($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'));

// Set the referer link.


// Check if the shopping cart is empty.
$empty = ($cart->getNumCartItems() == 0) ? true : false;

if (!$empty) {
	if (isset($_SESSION['cid'])) {
	  	$content .= "<h1>Confirm Address: Step 1 of 3</h1>";
		// Find the customer address.
		$query = "
		SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) as name, address1, address2, city, county, post_code, country, phone, email, delivery_address_id, delivery_address
		FROM customers, countries, customer_prefix
		WHERE customer_id='{$_SESSION['cid']}'
		AND customers.country_id=countries.country_id
		AND customers.prefix_id=customer_prefix.prefix_id
		LIMIT 1";
		$result = mysql_query($query);
		$row1 = mysql_fetch_array ($result, MYSQL_ASSOC);


		// Find the delivery address if one.
		if ($row1['delivery_address_id'] > 0) {
			$query = "
			SELECT *
			FROM customer_delivery_address, countries
			WHERE customer_id='{$_SESSION['cid']}'
			AND customer_delivery_address.country_id=countries.country_id
			LIMIT 1";
			$result = mysql_query($query);
			$row2 = mysql_fetch_array ($result, MYSQL_ASSOC);
		} else {
			$query = "
			SELECT country_id
			FROM customers
			WHERE customer_id='{$_SESSION['cid']}'
			LIMIT 1
			";
			$result = mysql_query ($query);
			$row = mysql_fetch_array ($result, MYSQL_NUM);
			$row1['country_id'] = $row[0];
		}

		// Display Address.
		$content .= "<table width=\"100%\">";
		$content .= "<tr>";
		$content .= "<td style=\"border:1px solid black; width:45%;\">";
		$content .= "<table cellspacing=\"3\" cellpadding=\"3\" style=\"width:100%;\">";
		$content .= "<tr><td colspan=\"2\" style=\"background-color:skyblue;\">Address</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Name:</td><td>{$row1['name']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Address 1:</td><td>{$row1['address1']}</td></tr>";
		if ($row1['address2']) $content .= "<tr><td style=\"font-weight:bold;\">Address 2:</td><td>{$row1['address2']}</td></tr>";
		if (isset($row1['address3'])) $content .= "<tr><td style=\"font-weight:bold;\">Address 3:</td><td>{$row1['address3']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">City:</td><td>{$row1['city']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">County:</td><td>{$row1['county']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Post Code:</td><td>{$row1['post_code']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Country:</td><td>{$row1['country']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Phone No:</td><td>{$row1['phone']}</td></tr>";
		$content .= "<tr><td style=\"font-weight:bold;\">Email:</td><td>{$row1['email']}</td></tr>";
		$content .= "</table>";
		$content .= "</td>";

		$content .= "<td style=\"width:10%;\">&nbsp;</td>";

		// Delivery Address.
		$content .= "<td valign=\"top\" style=\"border:1px solid black; width:45%;\">";
		$content .= "<table cellspacing=\"3\" cellpadding=\"3\" style=\"width:100%;\">";
		$content .= "<tr><td colspan=\"2\" style=\"background-color:skyblue;\">Delivery Address</td></tr>";
		if ($row1['delivery_address'] == "Y") {
			$content .= "<tr><td style=\"font-weight:bold;\">Name:</td><td>{$row1['name']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">Address 1:</td><td>{$row2['address1']}</td></tr>";
			if ($row2['address2']) $content .= "<tr><td style=\"font-weight:bold;\">Address 2:</td><td>{$row2['address2']}</td></tr>";
			if ($row2['address3']) $content .= "<tr><td style=\"font-weight:bold;\">Address 3:</td><td>{$row2['address3']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">City:</td><td>{$row2['city']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">County:</td><td>{$row2['county']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">Post Code:</td><td>{$row2['post_code']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">Country:</td><td>{$row2['country']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">Phone No:</td><td>{$row2['phone']}</td></tr>";
			$content .= "<tr><td style=\"font-weight:bold;\">Email:</td><td>{$row1['email']}</td></tr>";
		} else {
			$content .= "<tr><td style=\"font-weight:bold;\" colspan=\"2\">Same as Address</td></tr>";
		}
		$content .= "</table>";
		$content .= "</td>";
		$content .= "</tr>";
		$content .= "<tr>";
		$content .= "<td colspan=\"3\" align=\"center\">
		<form action=\"/shop/users/change_details.php\" method=\"post\">
		<input class=\"submit\" type=\"submit\" name=\"submit\" value=\"Update Details\" />
		<input type=\"hidden\" name=\"referer_link\" value=\"".$_SERVER['PHP_SELF']."\" />
		</form></td>";
		$content .= "</tr>";
		$content .= "</table>";

		if ($row1['delivery_address_id'] > 0) {
			$_SESSION['CountryCode'] = $row2['country_id'];
		} else {
			$_SESSION['CountryCode'] = $row1['country_id'];
		}

		// Display the form.
		$content .= '
            <form action="confirm.php" method="post">
            <p>Please click confirm to submit order:</p>
            <input type="hidden" name="stage" value="1" />
            <input class="submit" type="submit" name="submit" value="Confirm" /></form>
		';
	} else {
		$content .= '
            <table cellspacing="2" cellpadding="2" style="position:relative;top:25%;margin:auto;width:70%;text-align:center;font-weight:bold;" align="center">
            <tr>
            <td style="border:1px solid black;background-color:skyblue;">
            <p>Please log-in to complete your order:</p>
            <form action="'.$https.'/php/login.php" method="post">
            <input type="hidden" name="referer_link" value="'.$_SERVER['PHP_SELF'].'" />
            <input class="submit" type="submit" name="submit" value="Log-in" /></form>
            </td>
            <td style="width:5%;">&nbsp;</td>
            <td style="border:1px solid black;background-color:skyblue;">
            <p>Or if you don\'t have an account please register here:</p>
            <form action="'.$https.'/shop/users/register.php" method="post">
            <input type="hidden" name="referer_link" value="'.$_SERVER['PHP_SELF'].'" />
            <input class="submit" type="submit" name="submit" value="Register" /></form>
            </td>
            </tr>
            </table>
        ';

	}

	mysql_close(); // Close the database connection.

    // Include the HTML footer.
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
    
}  else {

	ob_end_clean(); // Delete the buffer.
	header ("Location: $merchant_website/index.php");
	exit();

}

?>
