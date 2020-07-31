<?php

namespace Navigation\View;

use Common\View\AbstractViewHelper;
use Laminas\Form\Element;


class NavigationForm extends AbstractViewHelper
{
	public function __invoke()
    {
        $serviceManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager');
        
    	/* @var $menuItemMapper \Navigation\Service\MenuItemService */
        $menuItemMapper = $serviceManager->get('UthandoNavigationMenuItem');
        $menuItems = $menuItemMapper->fetchAll();
        
        /* @var $menuMapper \Navigation\Service\MenuService */
        $menuMapper = $serviceManager->get('UthandoNavigationMenu');
        $menus = $menuMapper->fetchAll();
        
        $select = new Element\Select('position');
        $menuItemsOptions = [];
        $menuArray = [];
        
        foreach ($menus as $menu) {
            $menuArray[$menu->getMenuId()] = $menu->getMenu();
            
            $menuItemsOptions[$menu->getMenuId()]['options'][$menu->getMenuId() . '-' . '0'] = 'At top of this menu';
            $menuItemsOptions[$menu->getMenuId()]['empty_option'] = '---Please Select a page---';
            $menuItemsOptions[$menu->getMenuId()]['label'] = $menu->getMenu();
            
        }
        
        /* @var $page \Navigation\Model\MenuItemModel */
        foreach ($menuItems as $menuItem) {
            
            $ident = ($menuItem->getDepth() > 0) ? str_repeat('%space%%space%',($menuItem->getDepth())) . '%bull%%space%' : '';
            
            $menuItemsOptions[$menuItem->getMenuId()]['options'][$menuItem->getMenuId() . '-' . $menuItem->getMenuItemId()] = $ident . $menuItem->getLabel();
        }
        
        $select = new Element\Select('position');
        $select->setLabel('Location In Menu:');
        $select->setValueOptions($menuItemsOptions);
        $select->setEmptyOption('Please select a Position');
        $select->setAttribute('class', 'form-control');
        
        $element = $this->view->plugin('formElement');
        $errors = $this->view->plugin('formElementErrors');
        
        $html = $element($select);
        
        $html = str_replace('%space%', '&nbsp;', $html);
        $html = str_replace('%bull%', '&bull;', $html);
        
        $html = '<div class="form-group">
                     <label class="col-sm-4 control-label" for="position">'.$select->getLabel().'</label>
                     <div class="col-sm-8">' .
                         $html . '
                         <span class="help-block">' .
                             $errors($select, [
                                "class" => "unstyled"
                            ]) . '
                         </span>
                     </div>
                 </div>';
        
        return $html;
    }
}
