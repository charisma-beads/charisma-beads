<?php
namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Role\RoleInterface;

class IsAllowed extends AbstractPlugin
{
    /**
     * @var Zend\Permissions\Acl\Acl
     */
    protected $acl;

    /**
     * @var string
     */
    protected $identity;
    
    /**
     * @param string $acl
     */
    public function __construct($acl = null)
    {
        if ($acl) {
            $this->acl = $acl;
        }
    }

    /**
     * Get the current acl
     *
     * @return Zend\Permissions\Acl\Acl
     */
    public function getAcl()
    {
        if (!$this->acl) {
            $acl = $this->getController()
                ->getServiceLocator()
                ->get('User\Service\AclFactory');
            
            $this->acl = $acl;
        }
        
        return $this->acl;
    }

    /**
     * Check the acl
     *
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($resource = null, $privilege = null)
    {
        if (null === $this->acl) {
            $this->getAcl();
        }

        return $this->acl->isAllowed($this->getIdentity(), $resource, $privilege);
    }

    /**
     * Set the identity of the current request
     *
     * @param array|string|null|Zend\Permissions\Acl\Role\RoleInterface $identity
     * @return User\Controller\Plugin\Acl
     */
    public function setIdentity($identity)
    {
        if (is_array($identity)) {
            if (!isset($identity['role'])) {
                $identity['role'] = 'guest';
            }

            $identity = new Role($identity['role']);
        } elseif (is_object($identity) && is_string($identity->getRole())) {
            $identity = new Role($identity->getRole());
        } elseif (is_scalar($identity) && !is_bool($identity)) {
            $identity = new Role($identity);
        } elseif (null === $identity) {
            $identity = new Role('guest');
        } elseif (!$identity instanceof RoleInterface) {
            throw new \Exception('Invalid identity provided');
        }

        $this->identity = $identity;

        return $this;
    }

    /**
     * Get the identity, if no ident use Guest
     *
     * @return string
     */
    public function getIdentity()
    {
        if (null === $this->identity) {
            $identity = $this->getController()->plugin('identity');

            if (!$identity()) {
                return 'guest';
            }

            $this->setIdentity($identity());
        }

        return $this->identity;
    }

    /**
     * Proxy to the isAllowed method
     */
    public function __invoke($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
}
