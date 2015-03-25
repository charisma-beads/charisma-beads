<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM post_cost");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'postCostId'				=> $obj->post_cost_id,
		'postLevelId'               => $obj->post_level_id,
		'postZoneId'			    => $obj->post_zone_id,
	    'cost'                      => $obj->cost,
	    'vatInc'                    => $obj->vat_inc,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE postCost");
$c = 0;

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO postCost (".implode(', ', $keys).")
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
