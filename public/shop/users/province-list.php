<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");

// set up request object
$request = new \Zend\Http\PhpEnvironment\Request();

if ($request->isXmlHttpRequest()) {
	$adapter = new \Zend\Db\Adapter\Adapter(array(
		'driver'   => 'PDO_SQLITE',
		'database' => $_SERVER['DOCUMENT_ROOT'] . '/../data/countries.db',
	));
	
	$id = $request->getQuery('country_id', 1);
	
	$table = new \Zend\Db\TableGateway\TableGateway('provinces', $adapter);
	
	$rowset = $table->select(array('country_id' => $id));
	
	$formRenderer = new ViewRenderer();
	
	$content = $formRenderer->render('province-select', array(
		'rowset' => $rowset,
	));
	
} else {
	$content = 'Not Allowed!';
}

echo $content;
