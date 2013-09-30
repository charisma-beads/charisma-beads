<?php 

return array(
    'invokables' => array(
    	'User\Form\User'							=> 'User\Form\User',
        'User\Mapper\User'							=> 'User\Mapper\User',
    	'User\Service\User'							=> 'User\Service\User',
    ),
    'factories' => array(
    	'Zend\Authentication\AuthenticationService'	=> 'User\Service\Factory\AuthenticationFactory',
        'User\Service\AclFactory'					=> 'User\Service\Factory\AclFactory',
    ),
);