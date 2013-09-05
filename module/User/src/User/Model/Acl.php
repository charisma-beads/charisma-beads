<?php
namespace User\Model;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl
{
    /**
     * An array of user roles.
     *
     * @var array
     */
    protected $userRoles = array(
		'guest'			=> array(
			'label'			=> 'Guest',
			'parent'		=> null,
			'privileges'	=> array(
				'resources' => array(
					'menu:guest',
					'Guest'
				)
			)
		),
		'registered'    => array(
			'label'         => 'User',
			'parent'        => null,
			'privileges'    => array(
				'view'      => null,
				'add'       => null,
				'edit'      => null,
				'delete'    => null,
				'resources' => array(
					'menu:user',
					'User'
				)
			)
		),
		'admin'        => array(
			'label'         => 'Admin',
			'parent'        => 'registered',
			'privileges'    => array(
				'view'      => array(),
				'add'       => array(),
				'edit'      => array(),
				'delete'    => array(),
				'resources' => array(
					'menu:admin',
					'Admin'
				)
			)
		),
    );
    
    /**
     * An array of resources.
     *
     * @var array
    */
    protected $userResources = array(
    	// resources for menu.
    	'menu:admin', 'menu:guest', 'menu:user',
    	// resources based on controllers and DataBase tables.
    	'Admin', 'Guest', 'User',
    );
    
    /**
     * Set up role and resouces for power module.
    */
    public function __construct(array $config)
    {
    	// block all by default.
    	$this->deny();
    
    	if (isset($config['userRoles'])) {
    		$this->userRoles = $config['userRoles'];
    	}
    
    	if (isset($config['userResources'])) {
    		$this->userResources = $config['userResources'];
    	}
    
    	// add resources.
    	foreach ($this->userResources as $value) {
    		$this->addResource(new Resource($value));
    	}
    
    	foreach ($this->userRoles as $role => $values) {
    		$this->addRole(new Role($role), $values['parent']);
    
    		if (is_string($values['privileges'])) {
    			if ($values['privileges'] === 'all') {
    				$this->allow($role);
    			}
    		}
    
    		if (is_array($values['privileges'])) {
    			foreach ($values['privileges'] as $key => $value) {
    				if (is_array($value)) {
    					if ($key === 'resources') {
    						$this->allow($role, $value);
    					} else {
    						$this->allow($role, $value, $key);
    					}
    				}
    			}
    		}
    	}
    }
}
