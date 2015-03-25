<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM post_zones");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'postZoneId'				=> $obj->post_zone_id,
		'taxCodeId'                 => $obj->tax_code_id,
	    'zone'                      => $obj->zone,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE postZone");
$c = 0;

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO postZone (".implode(', ', $keys).")
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
