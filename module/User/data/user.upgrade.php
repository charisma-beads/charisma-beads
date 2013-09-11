<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM customers");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'userId'		=> $obj-> customer_id,
		'firstname' 	=> $obj->first_name,
		'lastname'		=> $obj->last_name,
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

foreach ($resultArray as $values) {
	$result = $mysqli->query("
		INSERT INTO user (userId, firstname, lastname, email, passwd, role, dateCreated, dateModified)
		VALUES (
			'".$values['userId']."',
			'".$values['firstname']."',
			'".$values['lastname']."',
			'".$values['email']."',
			'".$values['passwd']."',
			'".$values['role']."',
			'".$values['dateCreated']."',
			NOW()
		)
	");
	print "<pre>";
	print_r($values);
	print "</pre>";
}