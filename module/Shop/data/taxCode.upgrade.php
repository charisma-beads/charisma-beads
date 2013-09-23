<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM tax_codes");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'taxCodeId'			=> $obj->tax_code_id,
		'taxRateId' 		=> $obj->tax_rate_id,
		'taxCode'			=> $obj->tax_code,
		'description'		=> $obj->description,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE taxCode");
$c = 0;

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO taxCode (".implode(', ', $keys).")
		VALUES (";
	
	foreach ($values as $val) {
		$sql .= "'" . $val . "', ";
	}
	
	$sql = substr($sql, 0, -2);
	
	$sql .= "
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

$result->close();
