<?php 

return array(
	'invokables' => array(
		'Application\Model\SessionManager' => 'Application\Model\SessionManager',
	),
    'factories' => array(
    	'Application\SessionManager'       => 'Application\Service\SessionManagerFactory',
        'Application\SessionSaveHandler'   => 'Application\Service\SessionSaveHandlerFactory',
    ),
);