<?php
namespace User\Service;

use Traversable;
use User\Model\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('config');
        
        $aclRules = (array_key_exists('app_acl', $config)) ? $config['app_acl'] : array();
        
        $acl = new Acl($aclRules);
        
        return $acl;
    }
}
