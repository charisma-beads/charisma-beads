<?php

namespace Navigation\View\Navigation;

use Common\Service\ServiceManager;
use Navigation\Service\MenuService;


trait DbMenuTrait
{
    /**
     * @var bool
     */
    protected $multiArray;

    public function __invoke($container = null, $useMultiArray = true)
    {
        $this->multiArray = $useMultiArray;

        /* @var $service \Navigation\Service\MenuService */
        $service = $this->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(MenuService::class);

        $container = $service->getPages($container, $useMultiArray);

        return parent::__invoke($container);
    }

    /**
     * @return boolean
     */
    public function isMultiArray()
    {
        return $this->multiArray;
    }
} 