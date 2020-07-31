<?php

namespace Navigation\Service;

use Common\Service\ServiceManager;
use Common\Stdlib\ArrayUtils;
use Navigation\Model\MenuItemModel;
use Laminas\Config\Reader\Ini;
use Laminas\Navigation\Navigation;
use Laminas\Navigation\Service\AbstractNavigationFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;


class DbNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $service MenuItemService */
        $service = $serviceLocator->get(ServiceManager::class)
            ->getService(MenuItemService::class);

        $config = new Ini();

        if (null === $this->getName()) {
            $pages = $service->fetchAll();
        } else {
            $pages = $service->getMenuItemsByMenu($this->getName());
        }

        $pageArray = [];

        /* @var $page MenuItemModel */
        foreach ($pages as $page) {
            $p = $page->getArrayCopy();
            $params = $config->fromString($p['params']);

            // need to initialise params array else error occurs
            $p['params'] = [];

            // params contain route params and other element params like:
            // id, class etc.
            foreach ($params as $key => $value) {
                $p[$key] = $value;
            }

            if ($p['route'] == '0') {
                unset($p['route']);
                $p['uri'] = '#';
            } else {
                unset($p['uri']);
            }

            if ($p['resource'] == null) {
                unset($p['resource']);
            }

            $pageArray[] = $p;
        }

        $pageArray = ArrayUtils::listToMultiArray($pageArray);

        return new Navigation($this->preparePages($pageArray));
    }
}
