<?php 

return array(
	'invokables' => array(
		'Navigation\Form\Menu'		=> 'Navigation\Form\Menu',
		'Navigation\Mapper\Menu'	=> 'Navigation\Model\Mapper\Menu',
		'Navigation\Mapper\Page'	=> 'Navigation\Model\Mapper\Page',
		'Navigation\Gateway\Menu'	=> 'Navigation\Model\DbTable\Menu',
		'Navigation\Gateway\Page'	=> 'Navigation\Model\DbTable\Page',
	),
	'factories' => array(
		'Navigation\Form\Page'		=> 'Navigation\Service\Form\PageFactory',
	),
);
