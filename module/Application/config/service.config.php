<?php 

return array(
	'invokables' => array(
		'Application\Model\SessionManager'	=> 'Application\Model\SessionManager',
		'Application\Gateway\Session'		=> 'Application\Model\DbTable\Session',
	),
    'factories' => array(
    	'Application\SessionManager'		=> 'Application\Service\SessionManagerFactory',
        'Application\SessionSaveHandler'	=> 'Application\Service\SessionSaveHandlerFactory',
    ),
	'initializers' => array(
    	'Application\Service\DbAdapterInitializer' => 'Application\Service\DbAdapterInitializer',
    )
);