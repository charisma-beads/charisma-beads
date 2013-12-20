<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM product_category");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'productCategoryId'		=> $obj->category_id,
		//'productImageId' 		=> $obj->image,
		'ident'					=> $obj->ident,
		'category'				=> $obj->category,
		'lft'					=> $obj->lft,
		'rgt'					=> $obj->rgt,
		'enabled'				=> $obj->enabled,
		'discontinued'			=> $obj->discontinued,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE productCategory");

foreach ($resultArray as $values) {
	$sql = "
		INSERT INTO productCategory (productCategoryId, productImageId, ident, category, lft, rgt, enabled, discontinued, dateCreated, dateModified)
		VALUES (
			'".$values['productCategoryId']."',
			NULL,
			'".$values['ident']."',
			'".$values['category']."',
			'".$values['lft']."',
			'".$values['rgt']."',
			'".$values['enabled']."',
			'".$values['discontinued']."',
			NOW(), NOW()
		)
	";
	$result = $mysqli->query($sql);
	print "<pre>";
	print_r($sql);
	print "</pre>";
}

$result->close();
