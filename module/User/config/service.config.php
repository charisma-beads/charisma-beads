<?php 

return array(
    'invokables' => array(
        'User\Model\User' => 'User\Model\User',
    ),
    'factories' => array(
    	'Zend\Authentication\AuthenticationService'    => 'User\Service\AuthenticationFactory',
        'User\Service\AclFactory'                      => 'User\Service\AclFactory',
    ),
);