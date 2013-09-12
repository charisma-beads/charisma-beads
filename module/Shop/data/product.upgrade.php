<?php

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM products");

print_r($result->fetch);

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'productId'				=> $obj->product_id,
		'productCategoryId' 	=> $obj->category_id,
		'productSizeId'			=> $obj->size_id,
		'taxCodeId'				=> $obj->tax_code_id,
		'postUnitId'			=> $obj->postunit_id,
		'productGroupId'		=> $obj->group_id,
		'name'					=> $obj->product_name,
		'price'					=> $obj->price,
		'description'			=> $obj->description,
		'shortDescription'		=> $obj->short_description,
		'quantity'				=> $obj->quantity,
		'taxable'				=> $obj->vat_inc,
		'addPostage'			=> $obj->postage,
		'hits'					=> $obj->hits,
		'enabled'				=> $obj->enabled,
		'discontinued'			=> $obj->discontinued,
		'dateCreated'			=> $obj->date_entered,
	);
}

$result->close();

/* change db to new db */
$mysqli->select_db("charisma-beads");

$result = $mysqli->query("TRUNCATE product");

foreach ($resultArray as $values) {
	$keys = array_keys($values);
	$sql = "
		INSERT INTO product (".implode(', ', $keys).", dateModified)
		VALUES (";
	
	foreach ($values as $val) {
		$sql .= "'" . $val . "', ";
	}
	
	$sql .= "NOW()
		)
	";
	$result = $mysqli->query($sql);
	print "<pre>";
	print_r($sql);
	print "</pre>";
}

$result->close();
