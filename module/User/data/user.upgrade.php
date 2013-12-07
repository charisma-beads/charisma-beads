<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM customers");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'firstname' 	=> $mysqli->real_escape_string($obj->first_name),
		'lastname'		=> $mysqli->real_escape_string($obj->last_name),
		'email'			=> $obj->email,
		'passwd'		=> $obj->password,
		'role'			=> ($obj->email == 'shaun@shaunfreeman.co.uk' || $obj->email == 'vivien@charismabeads.co.uk' || $obj->email == 'richard@barnaclesfinch.me.uk') ? 'admin' : 'registered',
		'dateCreated'	=> $obj->registration_date,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE user");
$c = 0;

foreach ($resultArray as $values) {
	$sql = "
		INSERT INTO user (firstname, lastname, email, passwd, role, dateCreated, dateModified)
		VALUES (
			'".$values['firstname']."',
			'".$values['lastname']."',
			'".$values['email']."',
			'".$values['passwd']."',
			'".$values['role']."',
			'".$values['dateCreated']."',
			NOW()
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
