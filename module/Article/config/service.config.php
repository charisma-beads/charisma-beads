<?php

return array(
	'invokables' => array(
		'Article\Form\Article'		=> 'Article\Form\Article',
		'Article\Mapper\Article'	=> 'Article\Model\Mapper\Article',
		'Article\Gateway\Article' 	=> 'Article\Model\DbTable\Article',
	),
);