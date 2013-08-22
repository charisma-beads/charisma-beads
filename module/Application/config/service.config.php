<?php 

return array(
    'factories' => array(
    	'Application\SessionManager'       => 'Application\Service\SessionManagerFactory',
        'Application\SessionSaveHandler'   => 'Application\Service\SessionSaveHandlerFactory',
    ),
);