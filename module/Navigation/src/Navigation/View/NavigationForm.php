<?php

namespace Navigation\View;

use Application\View\AbstractViewHelper;
use Zend\Form\Element;

class NavigationForm extends AbstractViewHelper
{
	public function __invoke()
    {
        $model = $this->getServiceLocator()->getServiceLocator()->get('Core\Model\Navigation');
        $pages = $model->getGateway('page')->getFullTree();
        $menus = $model->fetchAllMenus();
        
        $select = new Element\Select('position');
        $pagesOptions = array();
        $menuArray = array();
        
        foreach ($menus as $menu) {
            $menuArray[$menu->menuId] = $menu->menu;
            
            $pagesOptions[$menu->menuId]['options'][$menu->menuId . '-' . '0'] = 'At top of this menu';
            $pagesOptions[$menu->menuId]['empty_option'] = '---Please Select a page---';
            $pagesOptions[$menu->menuId]['label'] = $menu->menu;
            
        }
        
        foreach ($pages as $page) {
            
            $ident = ($page->depth > 0) ? str_repeat('%space%%space%',($page->depth)) . '%bull%%space%' : '';
            
            $pagesOptions[$page->menuId]['options'][$page->menuId . '-' . $page->pageId] = $ident . $page->label;
        }
        
        $select = new Element\Select('position');
        $select->setLabel('Location In Menu:');
        $select->setValueOptions($pagesOptions);
        $select->setEmptyOption('Please select a Position');
        
        $element = $this->view->plugin('ztbFormElement');
        
        $html = $element($select);
        
        $html = str_replace('%space%', '&nbsp;', $html);
        $html = str_replace('%bull%', '&bull;', $html);
        
        return $html;
    }
}
