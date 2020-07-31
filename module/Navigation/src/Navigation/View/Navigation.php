<?php

namespace Navigation\View;

use Navigation\View\Navigation\DbMenu;
use Navigation\View\Navigation\TwitterBootstrapDbMenu;
use Navigation\View\Navigation\TwitterBootstrapMenu;
use Laminas\View\Helper\Navigation as ZendNavigation;


class Navigation extends ZendNavigation
{
    /**
     * Default set of helpers to inject into the plugin manager
     *
     * @var array
     */
    protected $defaultPluginManagerHelpers = [
        'uthandoDbMenu'     => DbMenu::class,
        'uthandoTbDbMenu'   => TwitterBootstrapDbMenu::class,
        'uthandoTbMenu'     => TwitterBootstrapMenu::class,
    ];

    /**
     * Retrieve plugin loader for navigation helpers
     *
     * Lazy-loads an instance of Navigation\HelperLoader if none currently
     * registered.
     *
     * @return \Laminas\View\Helper\Navigation\PluginManager
     */
    public function getPluginManager()
    {
        $pm = parent::getPluginManager();
        
        foreach ($this->defaultPluginManagerHelpers as $name => $invokableClass) {
            $pm->setInvokableClass($name, $invokableClass);
        }
        
        return $pm;
    }
}
