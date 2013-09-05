<?php 

return array(
    'invokables' => array(
    	'User\Controller\Admin' => 'User\Controller\UserAdminController',
    	'User\Controller\User' => 'User\Controller\UserController',
    ),
    'factories' => array(
    	'User\Controller\Auth' => 'User\Service\AuthControllerFactory',
    ),
);