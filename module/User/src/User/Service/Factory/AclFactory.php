<?php
namespace User\Service\Factory;

use User\Service\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('config');
        
        $aclRules = (array_key_exists('userAcl', $config)) ? $config['userAcl'] : array();
        
        $acl = new Acl($aclRules);
        
        return $acl;
    }
}