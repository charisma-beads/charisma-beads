<?php

return array(
	'invokables' => array(
		'Article\Model\Article' => 'Article\Model\Article',
	),
	'factories' => array(
		'Article\Gateway\Article' => 'Article\Service\DbTable\ArticleFactory',
	),
);