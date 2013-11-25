<?php

namespace User\View;

use Application\View\AbstractViewHelper;
use User\Controller\Plugin\IsAllowed as PluginIsAllowed;

class IsAllowed extends AbstractViewHelper
{
    /**
     * @var PluginIsAllowed
     */
    protected $pluginIsAllowed;
    
    /**
     * Returns the acl plugin instance
     *
     * @return Acl
     */
    public function __invoke($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
    
    /**
     * Proxy the acl plugin controller
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $acl = $this->getPluginIsAllowed();
        return call_user_func_array(array($acl, $method), $argv);
    }
    
    /**
     * Retrieve the acl plugin
     *
     * @return PluginIsAllowed
     */
    public function getPluginIsAllowed()
    {
        if ($this->pluginIsAllowed) {
            return $this->pluginIsAllowed;
        }
        
        $acl = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('User\Service\Acl');
        $identity = $this->view->plugin('identity');
    
        $this->pluginIsAllowed = new PluginIsAllowed($acl);
        $this->pluginIsAllowed->setIdentity($identity());
    
        return $this->pluginIsAllowed;
    }
}

