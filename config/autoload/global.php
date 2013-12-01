<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'session' => array(
		'config' => array(
			'class' => 'Zend\Session\Config\SessionConfig',
			'options' => array(
				'name' => 'charisma-beads',
			),
		),
		'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'save_handler' => 'Application\SessionSaveHandler',
		'validators' => array(
			'Zend\Session\Validator\RemoteAddr',
			'Zend\Session\Validator\HttpUserAgent',
		),
    ),
    'php_settings' => array(
    	'display_startup_errors' => false,
    	'display_errors' => true,
    	'max_execution_time' => 60,
    	'date.timezone' => 'Europe/London'
    ),
);
