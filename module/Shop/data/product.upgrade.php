<?php

function filterIdent($value)
{
	$find    = array('`', '&',   ' ', '"', "'");
	$replace = array('',  'and', '-', '',  '',);
	$new = str_replace($find, $replace,$value);

	$noalpha = 'ÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÀÈÌÒÙàèìòùÄËÏÖÜäëïöüÿÃãÕõÅåÑñÇç@°ºª';
	$alpha   = 'AEIOUYaeiouyAEIOUaeiouAEIOUaeiouAEIOUaeiouyAaOoAaNnCcaooa';

	$new = substr($new, 0, 255);
	$new = strtr($new, $noalpha, $alpha);

	// not permitted chars are replaced with "-"
	$new = preg_replace('/[^a-zA-Z0-9_\+]/', '-', $new);

	//remove -----'s
	$new = preg_replace('/(-+)/', '-', $new);

	return strtolower(rtrim($new, '-'));
}

$mysqli = new mysqli("localhost", "root", "password", "charisma_charismabeads");

$result = $mysqli->query("SELECT * FROM products");

$resultArray = array();

while($obj = $result->fetch_object()) {
	$resultArray[] = array(
		'productId'				=> $obj->product_id,
		'productCategoryId' 	=> $obj->category_id,
		'productSizeId'			=> $obj->size_id,
		'taxCodeId'				=> $obj->tax_code_id,
		'productPostUnitId'		=> $obj->postunit_id,
		'productGroupId'		=> $obj->group_id,
		'ident'					=> filterIdent($obj->product_name . ' ' . $obj->short_description),
		'name'					=> $obj->product_name,
		'price'					=> $obj->price,
		'description'			=> $mysqli->real_escape_string($obj->description),
		'shortDescription'		=> $mysqli->real_escape_string($obj->short_description),
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
$c = 0;

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
