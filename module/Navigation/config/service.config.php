<?php 

return array(
	'invokables' => array(
		'Navigation\Form\Menu'		=> 'Navigation\Form\Menu',
		'Navigation\Mapper\Menu'	=> 'Navigation\Model\Mapper\Menu',
		'Navigation\Mapper\Page'	=> 'Navigation\Model\Mapper\Page',
	),
	'factories' => array(
		'Navigation\Form\Page'		=> 'Navigation\Service\Form\PageFactory',
		'Navigation\Gateway\Menu'	=> 'Navigation\Service\DbTable\MenuFactory',
		'Navigation\Gateway\Page'	=> 'Navigation\Service\DbTable\PageFactory',
	),
);
