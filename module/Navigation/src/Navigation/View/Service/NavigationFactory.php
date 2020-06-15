<?php

namespace Navigation\View\Service;

use Navigation\View\Navigation;
use User\Service\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Identity;
use Zend\View\HelperPluginManager;


class NavigationFactory implements FactoryInterface
{
    /**
     * @var Identity
     */
    protected $identityHelper;

    /**
     * @var HelperPluginManager
     */
    protected $serviceLocator;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        $acl = $this->serviceLocator->getServiceLocator()
            ->get(Acl::class);

        $identity = $this->getIdentityHelper();

        $role = ($identity()) ? $identity()->getRole() : 'guest';

        $service = new Navigation();
        $service->setAcl($acl);
        $service->setRole($role);

        $service->setServiceLocator($this->serviceLocator->getServiceLocator());

        return $service;
    }

    /**
     * @return Identity
     */
    protected function getIdentityHelper()
    {
        if (!$this->identityHelper instanceof Identity) {
            $identity = $this->serviceLocator->get('identity');
            $this->identityHelper = $identity;
        }

        return $this->identityHelper;

    }
}
