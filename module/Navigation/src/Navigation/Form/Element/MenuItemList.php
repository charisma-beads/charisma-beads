<?php

namespace Navigation\Form\Element;

use Common\Service\ServiceManager;
use Navigation\Service\MenuItemService;
use Navigation\Service\MenuService;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;


class MenuItemList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $emptyOption = '---Please Select a page---';
    
    /**
     * @var int
     */
    protected $menuId = 0;

    /**
     * @param array|\Traversable $options
     * @return void|Select|\Laminas\Form\ElementInterface
     */
    public function setOptions($options)
    {
        parent::setOptions($options);
        
        if (isset($this->options['menu_id'])) {
            $this->setMenuId($this->options['menu_id']);
        }
    }

    /**
     * @return array
     */
    public function getValueOptions()
    {
    	return ($this->valueOptions) ?: $this->getMenuItems();
    }

    /**
     * @return array
     */
    public function getMenuItems()
    {
        $serviceManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class);

        /* @var $menuItemMapper MenuItemService */
        $menuItemMapper = $serviceManager->get(MenuItemService::class);

        /* @var $menuMapper MenuService */
        $menuMapper = $serviceManager->get(MenuService::class);

        $menuItemsOptions   = [];
        $menuArray          = [];

        if ($this->getMenuId()) {
            $items = $menuItemMapper->getMenuItemsByMenuId($this->getMenuId());
            $menus = [$menuMapper->getById($this->getMenuId())];
        } else {
            $menus = $menuMapper->fetchAll();
            $items = $menuItemMapper->fetchAll();
        }

        foreach ($menus as $menu) {
            $menuArray[$menu->getMenuId()] = $menu->getMenu();
            $menuItemsOptions[$menu->getMenuId()]['options'][$menu->getMenuId() . '-' . '0'] = 'At top of this menu';
            $menuItemsOptions[$menu->getMenuId()]['label'] = $menu->getMenu();
        }

        /* @var $page \Navigation\Model\MenuItemModel */
        foreach ($items as $menuItem) {
            $ident = ($menuItem->getDepth() > 0) ? str_repeat('&nbsp;&nbsp;',($menuItem->getDepth())) . '&bull;&nbsp;' : '';
            $menuItemsOptions[$menuItem->getMenuId()]['options'][] = [
                'value'                 => $menuItem->getMenuId() . '-' . $menuItem->getMenuItemId(),
                'label'                 => $ident . $menuItem->getLabel(),
                'disable_html_escape'   => true,
            ];
        }
        
        return $menuItemsOptions;
    }

    /**
     * @return int
     */
    public function getMenuId()
    {
    	return $this->menuId;
    }

    /**
     * @param $menuId
     * @return $this
     */
    public function setMenuId($menuId)
    {
    	$this->menuId = $menuId;
    	return $this;
    }
}
