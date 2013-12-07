<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");
$userDb = new mysqli("localhost", "root", "password", "charisma-beads");

$result = $mysqli->query("SELECT * FROM customers");

$customerBA = array();
$customer = array();
$customerDA = array();

while($obj = $result->fetch_object()) {
    
    //get userId
    $uResult = $userDb->query("SELECT * FROM user WHERE email='".$obj->email."'");
    $user = $uResult->fetch_object();
    
    $customer[] = array(
    	'userId' 	            => $user->userId,
        'prefixId'              => $obj->prefix_id,
        'firstname'             => $mysqli->real_escape_string($obj->first_name),
        'lastname'              => $mysqli->real_escape_string($obj->last_name),
        'dateCreated'			=> $obj->registration_date,
    );
    
	$customerBA[$user->userId] = array(
		'countryId'			    => $obj->country_id,
	    'address1'				=> $mysqli->real_escape_string($obj->address1),
		'address2'				=> $mysqli->real_escape_string($obj->address2),
		'address3'		        => $mysqli->real_escape_string($obj->address3),
		'city'		            => $mysqli->real_escape_string($obj->city),
		'county'				=> $mysqli->real_escape_string($obj->county),
		'postcode'				=> $obj->post_code,
		'phone'					=> $obj->phone,
	    'email'                 => $obj->email,
		'dateCreated'			=> $obj->registration_date,
	);
	
	if ($obj->delivery_address === 'Y') {
	    $cdaResult = $mysqli->query("SELECT * FROM customer_delivery_address WHERE customer_id=".$obj->customer_id);
	    $cda = $cdaResult->fetch_object();
	    $customerDA[$user->userId] = array(
	        'countryId'			    => $cda->country_id,
	        'address1'				=> $mysqli->real_escape_string($cda->address1),
	        'address2'				=> $mysqli->real_escape_string($cda->address2),
	        'address3'		        => $mysqli->real_escape_string($cda->address3),
	        'city'		            => $mysqli->real_escape_string($cda->city),
	        'county'				=> $mysqli->real_escape_string($cda->county),
	        'postcode'				=> $cda->post_code,
	        'phone'					=> $cda->phone,
	        'email'                 => $obj->email,
	        'dateCreated'			=> $obj->registration_date,
	    );
	}
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE customer");
$result = $mysqli->query("TRUNCATE customerAddress");
$c = 0;

foreach ($customer as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO customer (".implode(', ', $keys).", dateModified)
		VALUES (";

	foreach ($values as $val) {
		$sql .= "'" . $val . "', ";
	}

	$sql .= "NOW()
		)
	";

	$result = $mysqli->query($sql);
	
	$id = $mysqli->insert_id;
	
	// insert billing address and get insertID
	$cbaKeys = array_keys($customerBA[$values['userId']]);
	
	$cbaSql = "
	  INSERT INTO customerAddress (".implode(', ', $cbaKeys).", dateModified, customerId)
	  VALUES (";
    
    foreach ($customerBA[$values['userId']] as $val) {
    	$cbaSql .= "'" . $val . "', ";
    }
    
    $cbaSql .= "NOW(), ".$id."
	  )
    ";
    
    $cbaResult = $mysqli->query($cbaSql);
    
    $cbaId = $mysqli->insert_id;
	
    // insert delivery address if different and get ID
	if (key_exists($values['userId'], $customerDA)) {
	    
	    $keys = array_keys($customerDA[$values['userId']]);
	    $cdaSql = "
		  INSERT INTO customerAddress (".implode(', ', $keys).", dateModified, customerId)
		  VALUES (";
	    
	    foreach ($customerDA[$values['userId']] as $val) {
	    	$cdaSql .= "'" . $val . "', ";
	    }
	    
	    $cdaSql .= "NOW(), ".$id."
		  )
	    ";
	    
	    $cdaResult = $mysqli->query($cdaSql);
	    
	    $cdaId = $mysqli->insert_id;
	} else {
	    $cdaId = $cbaId;
	}
	
	// insert cba and cda into customer table
	$cbaCdaSql = "UPDATE customer SET billingAddressId=".$cbaId.", deliveryAddressId=".$cdaId." WHERE customerId=".$id;
	
	$cbaCdaResult = $mysqli->query($cbaCdaSql);
	
	if (!$cbaResult) {
		print "<pre>";
		print_r($cbaSql);
		print "</pre>";
	}
	
	if (!$cdaResult) {
		print "<pre>";
		print_r($cdaSql);
		print "</pre>";
	}
	
	if (!$cbaCdaResult) {
		print "<pre>";
		print_r($cbaCdaSql);
		print "</pre>";
	}

	if (!$result) {
		print "<pre>";
		print_r($sql);
		print "</pre>";
	} else {
		$c++;
	}

}

print 'rows Inserted = ' . $c;
