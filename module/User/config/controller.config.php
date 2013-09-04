<?php 

return array(
    'invokables' => array(
    	'User\Controller\Admin' => 'User\Controller\AdminController',
    	'User\Controller\User' => 'User\Controller\UserController',
    ),
    'factories' => array(
    	'User\Controller\Auth' => 'User\Service\AuthControllerFactory',
    ),
);