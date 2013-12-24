<?php // login.php Tuesday, 5 April 2005
// This page allows logged-in users to change their details.

// Set the page title.
$page_title = "Change Address";

if (isset($_POST['referer_link'])) {
	$referer_link = $_POST['referer_link'];
} else {
	$referer_link = NULL;
}

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['cid'])) {

    header ("Location: $merchant_website/index.php");
    
} else {

	$content .= "<h1>$page_title</h1>";
	
	//print "<pre>";
	//print_r ($_POST);
	//print "</pre>";

	if (isset($_GET['change_country']) && $_GET['change_country'] == 1) {
		$content .='
		<form action="'.$_SERVER['PHP_SELF'].'" method="post">
		<input type="hidden" name="referer_link" value="'.$_GET['referer_link'].'" />
			<table>
				<tr><td align="right"><b>Choose your country or region:</b></td><td align="left"><select id="country_select" name="country"><option>Select One</option>
		';
		// Retrieve all the countries and add to the pull down menu.
		$query = "
			SELECT * 
			FROM countries
			ORDER BY country ASC
		";
		$result = mysql_query ($query);
		
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			$content .= '
				<option value="'.$row['country_id'].':'.$row['country'].'">'.$row['country'].'</option>
			';
		}
		$content .= '
				</select></td></tr>
				<noscript>
				<tr><td><input type="submit" name="submit" value="Set Country" /></td></tr>
				</noscript>
			</table>
		</form>
		';
		
} else {
	
	if (isset($_POST['submit']) && $_POST['submit'] == "Change Details") {
	
		$error = FALSE;
	
		// Start Invoice address check.
		// Check for name prefix.
    	if ($_POST['prefix'] > 0) {
			$prefix =(stripslashes(trim($_POST['prefix'])));
        	$prefix = escape_data($_POST['prefix']);
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your name prefix!</p></span>";
    	}
	
    	// Check for first name.
    	if (preg_match ("/^[[:alpha:],' -]{2,15}$/i", stripslashes(trim($_POST['first_name'])))) {
        	$first_name = escape_data(ucwords (strtolower($_POST['first_name'])));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your first name!</p></span>";
    	}

    	// Check for last name.
    	if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['last_name'])))) {
        	$last_name = escape_data(ucwords (strtolower($_POST['last_name'])));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your last name!</p></span>";
    	}
	
		// Check for address1.
    	if (preg_match ("/^[[:alnum:].', -\/]{5,30}$/i", stripslashes(trim($_POST['address1'])))) {
        	$address1 = escape_data(ucwords (strtolower($_POST['address1'])));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter the first line of your address!</p></span>";
    	}
	
		// Check for town/city.
    	if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['city'])))) {
        	$city = escape_data(ucwords (strtolower($_POST['city'])));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your Town or City!</p></span>";
    	}
	
		// Check for county/state.
    	if (preg_match ("/^[[:alpha:].' -]{2,100}$/i", stripslashes(trim($_POST['county'])))) {
        	$county = escape_data(ucwords (strtolower($_POST['county'])));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your County or State!</p></span>";
    	}  
	
		// Check for Post/Zip code.
		if (preg_match ("/^[[:alnum:] ]{5,10}$/i", stripslashes(trim($_POST['post_code']))) || $_POST['country'] != 1) {
        	$post_code = escape_data(strtoupper($_POST['post_code']));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your Post or Zip code!</p></span>";
    	} 
		
		// Check for Country.
		if ($_POST['country'] > 0) {
			$country =(stripslashes(trim($_POST['country'])));
        	$country = escape_data($_POST['country']);
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your country!</p></span>";
    	}
			
		// Check for telephone No.
    	if (preg_match ("/^[[:digit:] ]{11,}$/i", stripslashes(trim($_POST['phone'])))) {
        	$phone = escape_data($_POST['phone']);
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your phone number!</p></span>";
    	}
    	
    	// Check for an email address.
    	if (preg_match ("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", stripslashes(trim($_POST['email'])))) {
        	$email = escape_data(strtolower($_POST['email']));
    	} else {
        	$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter a valid email address!</p></span>";
    	} 
		
		// Check Delivery address if one is given.
		if ($_POST['delivery_address'] == 1) {
			
			// Check for address1.
    		if (preg_match ("/^[[:alnum:].', -]{5,30}$/i", stripslashes(trim($_POST['delivery_address1'])))) {
        		$delivery_address1 = escape_data(ucwords (strtolower($_POST['delivery_address1'])));
    		} else {
        		$error = TRUE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter the first line of your delivery address!</p></span>";
    		}
			
			// Check for town/city.
    		if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['delivery_city'])))) {
        		$delivery_city = escape_data(ucwords (strtolower($_POST['city'])));
    		} else {
        		$error = TRUE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your delivery Town or City!</p></span>";
    		}
			
			// Check for county/state.
    		if (preg_match ("/^[[:alpha:].' -]{2,100}$/i", stripslashes(trim($_POST['delivery_county'])))) {
        		$delivery_county = escape_data(ucwords (strtolower($_POST['delivery_county'])));
    		} else {
        		$error = TRUE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your delivery County or State!</p></span>";
    		}
			
			// Check for Post/Zip code.
			if (preg_match ("/^[[:alnum:] ]{5,10}$/i", stripslashes(trim($_POST['delivery_post_code']))) || $_POST['country'] != 1) {
        		$delivery_post_code = escape_data(strtoupper($_POST['delivery_post_code']));
    		} else {
        		$error = TRUE;
        	$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your delivery Post or Zip code!</p></span>";
    		}
			
			// Check for Country.
			if ($_POST['delivery_country'] > 0) {
				$delivery_country =(stripslashes(trim($_POST['delivery_country'])));
        		$delivery_country = escape_data($_POST['delivery_country']);
    		} else {
        		$error = TRUE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your delivery country!</p></span>";
    		}
			
			// Check for telephone No.
    		if (preg_match ("/^[[:digit:] ]{11,}$/i", stripslashes(trim($_POST['delivery_phone'])))) {
        		$delivery_phone = escape_data($_POST['delivery_phone']);
    		} else {
        		$error = TRUE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your delivery phone number!</p></span>";
    		}
			
			$delivery_address = "Y";
			// End delivery address checking.
			
		} else {
			
			$delivery_address = "N";
		}
		
		// Update the database.
		if ($error != TRUE) { // If everything is OK.
			// Check for a delivery address.
			$query = "
			SELECT delivery_address_id
			FROM customer_delivery_address
			WHERE customer_id={$_SESSION['cid']}
			LIMIT 1
			";
			$result = mysql_query ($query);
			if (mysql_num_rows ($result) == 1) {
				$row = mysql_fetch_array ($result, MYSQL_NUM);
				$DAId = $row[0];
			} else {
				$DAId = 0;
			}
			
			if ($delivery_address == "N") {
				
				// If there is a delivery address, delete it.
				if ($DAId > 0) {
					$query = "
					DELETE
					FROM customer_delivery_address
					WHERE delivery_address_id=$DAId
					LIMIT 1
					";
					$result = mysql_query ($query);
					$DAId = 0;
				}
			} else {
			
				// If there's not a delivery address, create it else update it.
				if ($DAId == 0) {
					$query = "
					INSERT
					INTO customer_delivery_address
					(customer_id, address1, address2, address3, city, county, post_code, country_id, phone)
					VALUES ({$_SESSION['cid']}, '$delivery_address1', '" . escape_data (ucwords (strtolower($_POST['delivery_address2']))) . "', '" . escape_data (ucwords (strtolower($_POST['delivery_address3']))) . "', '$delivery_city', '$delivery_county', '$delivery_post_code', $delivery_country, '$delivery_phone')
					";
					$result = mysql_query ($query);
					$DAId = mysql_insert_id ();
					
				} else {
				
					$query = "
					UPDATE customer_delivery_address
					SET address1='$delivery_address1', address2='" . escape_data (ucwords (strtolower($_POST['delivery_address2']))) . "', address3='" . escape_data (ucwords (strtolower($_POST['delivery_address3']))) . "', city='$delivery_city', county='$delivery_county', post_code='$delivery_post_code', country_id=$delivery_country, phone='$delivery_phone'
					WHERE delivery_address_id=$DAId
					LIMIT 1
					";
					
					$result = mysql_query ($query);
				}
			
			} 
			
			// Update the user.
        	$query = "
			UPDATE customers 
			SET prefix_id=$prefix, first_name='$first_name', last_name='$last_name', address1='$address1', address2='" . escape_data (ucwords (strtolower($_POST['address2']))) . "', address3='" . escape_data (ucwords (strtolower($_POST['address3']))) . "', city='$city', county='$county', post_code='$post_code', country_id=$country, phone='$phone', email='$email', delivery_address_id=$DAId, delivery_address='$delivery_address' 
			WHERE customer_id={$_SESSION['cid']}
			LIMIT 1
			";
        	$result = mysql_query ($query); // Run the query.
			
			if (isset($_POST['referer_link'])) {
				$referer_link = "$https".$_POST['referer_link'];
			} else {
				$referer_link = "$https/shop/users/change_details.php";
			}
					
			ob_end_clean(); // Delete the buffer.
			header ("Location: " . $referer_link);
            exit();
			
		} else {
			$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />Please Try Again</p></span>";
			$content .= '
			<form ation="'.$_SERVER['PHP_SELF'].'" method="post">';
             if ($referer_link) {
                $content .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
            }
			$content .= '
			<input type="submit" name="submit" value="Try Again!" class="submit"/>
			</form>
			';
		}
	
	} else {
	 	
		// Display the form.
		// Find the customer address.
		$query = "
		SELECT * 
		FROM customers, countries, customer_prefix 
		WHERE customer_id='{$_SESSION['cid']}' 
		AND customers.country_id=countries.country_id 
		AND customers.prefix_id=customer_prefix.prefix_id 
		LIMIT 1
		";
		$result = mysql_query($query);
		$row1 = mysql_fetch_array ($result, MYSQL_ASSOC);
		
		// Find the delivery address
		if ($row1['delivery_address'] == "Y") {
			$query = "
			SELECT * 
			FROM customer_delivery_address, countries 
			WHERE customer_id='{$_SESSION['cid']}' 
			AND customer_delivery_address.country_id=countries.country_id 
			LIMIT 1
			";
			$result = mysql_query($query);
			$row2 = mysql_fetch_array ($result, MYSQL_ASSOC);
		}
		
		if (isset($_POST['country'])) {
			$c = explode(':', $_POST['country']);
			$country_set = $c[0];
			$row1['country'] = $c[1];
			if (isset($row2['country'])) $row2['country'] = $c[1];
		} else {
			$country_set = $row1['country_id'];
		}
	
		// Display Address.
		$content .= '
        <p><span class="required">*</span> Required fields</p>
		<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
        if ($referer_link) {
            $content .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
        }
		$content .= '
    	<div class="box">
    	<table style="margin-right:auto; margin-left:auto;"> 
	
		<tr><td align="right"><span class="required">*</span><b>Prefix:</b></td><td align="left"><select name="prefix"><option>Select</option>';
			// Retrieve all the prefixes and add to the pull down menu.
			$query = "
			SELECT * 
			FROM customer_prefix
			";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
				$content .= '<option ';
		
				if ($row1['prefix'] == $row['prefix']) {
					$content .= 'selected="selected"';
				}
			
				$content .= " value=\"{$row['prefix_id']}\">{$row['prefix']}</option>";
			}
			$content .= '
			</select></td></tr>
	
    	<tr><td><span class="required">*</span><b>Forname:</b></td> <td><input type="text" name="first_name" size="15" maxlength="15" value="'.$row1['first_name'].'" /></td></tr>

   		<tr><td><span class="required">*</span><b>Surname:</b></td> <td><input type="text" name="last_name" size="30" maxlength="30" value="'.$row1['last_name'].'"/></td></tr>
	
		<tr><td><span class="required">*</span><b>Address 1:</b></td> <td align="left"><input type="text" name="address1" size="30" maxlength="30" value="'.$row1['address1'].'" /></td></tr>

		<tr><td><b>Address 2:</b></td> <td align="left"><input type="text" name="address2" size="30" maxlength="30" value="'.$row1['address2'].'" /></td></tr>
		
		<tr><td><b>Address 3:</b></td> <td align="left"><input type="text" name="address3" size="30" maxlength="30" value="'.$row1['address3'].'" /></td></tr>

		<tr><td><span class="required">*</span><b>Town/City:</b></td> <td><input type="text" name="city" size="30" maxlength="30" value="'.$row1['city'].'" /></td></tr>
		
		';
		if ($country_set == 1) {
        $content .= '
		<tr><td align="right"><span class="required">*</span><b>County:</b></td><td align="left"><select name="county">';
			$handle = fopen($_SERVER['DOCUMENT_ROOT']."/admin/modules/web_shop/post_validation/uk_counties.txt", "r");
			if ($handle) {
				while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
					if ($row1['county'] == strip_tags($data[0])) {
						$replace = '"'.$row1['county'].'"';
						$data[0] = str_replace($replace, $replace.' selected="selected"', $data[0]);
					}
					$content .= $data[0]."\n";
			
				}
				fclose($handle);
			}
		$content .= '
		</select></td></tr>
		'; } else { $content .= '
				
			<tr><td align="right"><span class="required">*</span><b>County:</b></td> <td align="left"><input type="text" name="county" size="30" maxlength="30" value="'.$row1['county'].'" /></td></tr>
				
		'; } $content .= '
				
		<tr><td><span class="required">*</span><b>Postcode:</b></td> <td><input type="text" name="post_code" size="10" maxlength="10" value="'.$row1['post_code'].'" /></td></tr>

		<tr><td align="right"><span class="required">*</span><b>Country:</b></td><td align="left">
			<span>';
        if (isset ($row1['country'])) $content .= $row1['country'];
        $content .= '</span>
			<input type="hidden" name="country" value="'.$country_set.'" />
			<a href="/shop/users/change_details.php?change_country=1&referer_link='.$referer_link.'&country_set='.$country_set.'">Change Country</a>
		</td></tr>
		<tr><td><span class="required">*</span><b>Phone:</b></td> <td><input type="text" name="phone" size="20" maxlength="20" value="'.$row1['phone'].'" /></td></tr>

		<tr><td><span class="required">*</span><b>Email:</b></td> <td><input type="text" name="email" size="40" value="'.$row1['email'].'" /></td></tr>

		<tr>
            <td colspan="2">
                <p>Is the delivery address different from above?<br />
                    <b>Yes:</b>
                    <input id="da_show" type="radio" name="delivery_address" value="1" ';
                    if ($row1['delivery_address'] == "Y") $content .= 'checked="checked"';
                    $content .= ' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>No:</b><input id="da_hide" type="radio" name="delivery_address" value="0" ';
                    if ($row1['delivery_address'] == "N") $content .= 'checked="checked"';
                    $content .= '/></td></tr>

	 	<!-- Delivery Address -->
		<tr><td colspan="2">
		<span id="D_address" ';
        if ($row1['delivery_address'] == "N") $content .= 'style="display:none"';
        $content .= '>
		<b>Please enter your delivery address below:</b><br /><br />
		<table align="left">
		<tr><td><span class="required">*</span><b>Address 1:</b></td> <td align="left"><input type="text" name="delivery_address1" size="30" maxlength="30" value="';
        if (isset ($row2['address1'])) $content .= $row2['address1'];
        $content .= '" /></td></tr>
												 
		<tr><td><b>Address 2:</b></td> <td align="left"><input type="text" name="delivery_address2" size="30" maxlength="30" value="';
        if (isset ($row2['address2'])) $content .= $row2['address2'];
        $content .= '" /></td></tr>
				
		<tr><td><b>Address 3:</b></td> <td align="left"><input type="text" name="delivery_address3" size="30" maxlength="30" value="';
        if (isset ($row2['address3'])) $content .= $row2['address3'];
        $content .= '" /></td></tr>

		<tr><td><span class="required">*</span><b>Town/City:</b></td> <td><input type="text" name="delivery_city" size="30" maxlength="30" value="';
        if (isset ($row2['city'])) $content .= $row2['city'];
        $content .= '" /></td></tr>';

		if ($country_set == 1) {

        $content .= '
		<tr><td align="right"><span class="required">*</span><b>County:</b></td><td align="left"><select name="delivery_county">';
			$handle = fopen($_SERVER['DOCUMENT_ROOT']."/admin/modules/web_shop/post_validation/uk_counties.txt", "r");
			if ($handle) {
				while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
					if (isset($row2) && $row2['county'] == strip_tags($data[0])) {
						$replace = '"'.$row1['county'].'"';
						$data[0] = str_replace($replace, $replace.' selected="selected"', $data[0]);
					}
					$content .= $data[0]."\n";
			
				}
				fclose($handle);
			}
		$content .= '
		</select></td></tr>
		'; } else { $content .= '
				
			<tr><td align="right"><span class="required">*</span><b>County:</b></td> <td align="left"><input type="text" name="delivery_county" size="30" maxlength="30" value="';
        if (isset($row2['county'])) $content .= $row2['county'];
        $content .= '" /></td></tr>
				
		'; } $content .= '
		<tr><td><span class="required">*</span><b>Postcode:</b></td> <td><input type="text" name="delivery_post_code" size="10" maxlength="10" value="';
        if (isset ($row2['post_code'])) $content .= $row2['post_code'];
        $content .= '" /></td></tr>

		<tr><td align="right"><span class="required">*</span><b>Country:</b></td><td align="left">
			<span>';
        if (isset ($row2['country'])) {
            $content .= $row2['country'];
        } else {
            $content .= $row1['country'];
        }
        $content .= '</span>
			<input type="hidden" name="delivery_country" value="'.$country_set.'" />
		</td></tr>
			

		<tr><td><span class="required">*</span><b>Phone:</b></td> <td><input type="text" name="delivery_phone" size="20" maxlength="20" value="';
        if (isset ($row2['phone'])) $content .= $row2['phone'];
        $content .= '" /></td></tr>
		</table>
		</span>
		</td></tr>
		<!-- End Delivery Adress -->
		<!-- End form -->
		<tr><td colspan="2" style="text-align:center;"><input type="submit" name="submit" value="Change Details" class="submit"/></td></tr>
    	</table>
    	</div>
    	</form>
		';

     } // End of form
}
    

} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
