<?php 

return array(
	'invokables' => array(
		'Application\Model\SessionManager' => 'Application\Model\SessionManager',
	),
    'factories' => array(
    	'Application\Gateway\Session'		=> 'Application\Service\DbTable\SessionFactory',
    	'Application\SessionManager'		=> 'Application\Service\SessionManagerFactory',
        'Application\SessionSaveHandler'	=> 'Application\Service\SessionSaveHandlerFactory',
    ),
);