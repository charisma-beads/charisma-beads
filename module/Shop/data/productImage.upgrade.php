<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM products");

$resultArray = array();

while($obj = $result->fetch_object()) {
	if ($obj->image_status == '1') {
		$resultArray[] = array(
			'productId'		=> $obj->product_id,
			'thumbnail'		=> $obj->image,
			'full'			=> $obj->image,
			'isDefault'		=> 1,
			'dateCreated'	=> $obj->date_entered,
		);
	}
}

$result->close();

/* change db to new db */
$mysqli->select_db("uthando-cms");

$result = $mysqli->query("TRUNCATE productImage");
$c = 0;

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO productImage (".implode(', ', $keys).", dateModified)
		VALUES (";
	
	foreach ($values as $val) {
		$sql .= "'" . $val . "', ";
	}
	
	$sql .= "NOW()
		)
	";
	
	$result = $mysqli->query($sql);
	
	if (!$result) {
		print "<pre>";
		print_r($sql);
		print "</pre>";
	} else {
		$c++;
	}
	
}

print 'rows Inserted = ' . $c;
