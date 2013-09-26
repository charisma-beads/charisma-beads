<?php

return array(
	'invokables' => array(
		'Article\Form\Article'		=> 'Article\Form\Article',
		'Article\Mapper\Article'	=> 'Article\Model\Mapper\Article',
	),
	'factories' => array(
		'Article\Gateway\Article' => 'Article\Service\DbTable\ArticleFactory',
	),
);