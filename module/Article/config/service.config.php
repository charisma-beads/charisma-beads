<?php

return array(
	'shared' 		=> array(
		'Article\Form\Article'			=> false,
	),
	'invokables' 	=> array(
		'Article\Form\Article'			=> 'Article\Form\Article',
		'Article\InputFilter\Article'	=> 'Article\InputFilter\Article',
		'Article\Mapper\Article'		=> 'Article\Mapper\Article',
		'Article\Service\Article' 		=> 'Article\Service\Article',
	),
);