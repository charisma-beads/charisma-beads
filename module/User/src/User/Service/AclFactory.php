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
        
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        $aclRules = $config['app_acl'];
        
        $acl = new Acl($aclRules);
        
        return $acl;
    }
}
