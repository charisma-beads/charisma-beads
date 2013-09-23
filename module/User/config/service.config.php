<?php 

return array(
    'invokables' => array(
    	'User\Form\User'	=> 'User\Form\User',
        'User\Mapper\User'	=> 'User\Model\Mapper\User',
    ),
    'factories' => array(
    	'Zend\Authentication\AuthenticationService'		=> 'User\Service\AuthenticationFactory',
        'User\Service\AclFactory'						=> 'User\Service\AclFactory',
    	'User\Gateway\User'								=> 'User\Service\DbTable\UserFactory',
    ),
);