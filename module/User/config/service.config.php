<?php 

return array(
	'shared' => array(
	    'User\Form\Password'                        => false,
		'User\Form\User'							=> false,
	),
    'invokables' => array(
        'User\Form\Password'                        => 'User\Form\Password',
    	'User\Form\User'							=> 'User\Form\User',
        
        'User\InputFilter\Password'                 => 'User\InputFilter\Password',
    	'User\InputFilter\User'						=> 'User\InputFilter\User',
        
        'User\Mapper\User'							=> 'User\Mapper\User',
        
    	'User\Service\User'							=> 'User\Service\User',
    ),
    'factories' => array(
    	'Zend\Authentication\AuthenticationService'	=> 'User\Service\Factory\AuthenticationFactory',
        'User\Service\Acl'					        => 'User\Service\Factory\AclFactory',
        'User\Navigation'                           => 'User\Service\Factory\UserNavigationFactory',
    ),
);