<?php 

return array(
	'invokables' => array(
		'Navigation\Form\Menu'		=> 'Navigation\Form\Menu',
		'Navigation\Mapper\Menu'	=> 'Navigation\Mapper\Menu',
		'Navigation\Mapper\Page'	=> 'Navigation\Mapper\Page',
		'Navigation\Service\Menu'	=> 'Navigation\Service\Menu',
		'Navigation\Service\Page'	=> 'Navigation\Service\Page',
	),
	'factories' => array(
		'Navigation\Form\Page'		=> 'Navigation\Service\Form\PageFactory',
	),
);
