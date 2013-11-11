<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");
$userDb = new mysqli("localhost", "root", "password", "charisma-beads");

$result = $mysqli->query("SELECT * FROM customers");

$resultArray = array();

$customerDeliveryAddress = array();

while($obj = $result->fetch_object()) {
    
    //get userId
    $uResult = $userDb->query("SELECT * FROM user WHERE email='".$obj->email."'");
    $user = $uResult->fetch_object();
    
	$resultArray[] = array(
		'userId' 	            => $user->userId,
		'countryId'			    => $obj->country_id,
	    'address1'				=> $mysqli->real_escape_string($obj->address1),
		'address2'				=> $mysqli->real_escape_string($obj->address2),
		'address3'		        => $mysqli->real_escape_string($obj->address3),
		'city'		            => $mysqli->real_escape_string($obj->city),
		'county'				=> $mysqli->real_escape_string($obj->county),
		'postcode'				=> $obj->post_code,
		'phone'					=> $obj->phone,
		'dateCreated'			=> $obj->registration_date,
	);
	
	if ($obj->delivery_address === 'Y') {
	    $cdaResult = $mysqli->query("SELECT * FROM customer_delivery_address WHERE customer_id=".$obj->customer_id);
	    $cda = $cdaResult->fetch_object();
	    $customerDeliveryAddress[$obj->customer_id] = array(
	        'userId' 	            => $user->userId,
	        'countryId'			    => $cda->country_id,
	        'address1'				=> $mysqli->real_escape_string($cda->address1),
	        'address2'				=> $mysqli->real_escape_string($cda->address2),
	        'address3'		        => $mysqli->real_escape_string($cda->address3),
	        'city'		            => $mysqli->real_escape_string($cda->city),
	        'county'				=> $mysqli->real_escape_string($cda->county),
	        'postcode'				=> $cda->postcode,
	        'phone'					=> $cda->phone,
	        'dateCreated'			=> $obj->registration_date,
	    );
	}
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE customerAddress");
$result = $mysqli->query("TRUNCATE customerBillingAddress");
$result = $mysqli->query("TRUNCATE customerDeliveryAddress");
$c = 0;

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO customerAddress (".implode(', ', $keys).", dateModified)
		VALUES (";

	foreach ($values as $val) {
		$sql .= "'" . $val . "', ";
	}

	$sql .= "NOW()
		)
	";

	$result = $mysqli->query($sql);
	
	$id = $mysqli->insert_id;
	
	$ba = "
		INSERT INTO customerBillingAddress (customerAddressId)
		VALUES (".$id.")";
	
	$baResult = $mysqli->query($ba);
	
	if (key_exists($values['userId'], $customerDeliveryAddress)) {
	    
	    $keys = array_keys($customerDeliveryAddress[$values['userId']]);
	    $cdaSql = "
		  INSERT INTO customerAddress (".implode(', ', $keys).", dateModified)
		  VALUES (";
	    
	    foreach ($customerDeliveryAddress[$values['userId']] as $val) {
	    	$cdaSql .= "'" . $val . "', ";
	    }
	    
	    $cdaSql .= "NOW()
		  )
	    ";
	    
	    $cdaResult = $mysqli->query($cdaSql);
	    
	    $id = $mysqli->insert_id;
	}
	
	$da = "
		INSERT INTO customerDeliveryAddress (customerAddressId)
		VALUES (".$id.")";
	
	$daResult = $mysqli->query($da);

	if (!$result && !$baResult && !$daResult) {
		print "<pre>";
		print_r($sql);
		print "</pre>";
	} else {
		$c++;
	}

}

print 'rows Inserted = ' . $c;

$result->close();