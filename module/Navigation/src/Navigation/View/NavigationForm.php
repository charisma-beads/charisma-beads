<?php

namespace Navigation\View;

use Application\View\AbstractViewHelper;
use Zend\Form\Element;

class NavigationForm extends AbstractViewHelper
{
	public function __invoke()
    {
    	/* @var $gateway \Navigation\Service\Page */
        $pageMapper = $this->getServiceLocator()->getServiceLocator()->get('Navigation\Service\Page');
        $pages = $pageMapper->fetchAll();
        
        /* @var $menuMapper \Navigation\Service\Menu */
        $menuMapper = $this->getServiceLocator()->getServiceLocator()->get('Navigation\Service\Menu');
        $menus = $menuMapper->fetchAll();
        
        $select = new Element\Select('position');
        $pagesOptions = array();
        $menuArray = array();
        
        foreach ($menus as $menu) {
            $menuArray[$menu->getMenuId()] = $menu->getMenu();
            
            $pagesOptions[$menu->getMenuId()]['options'][$menu->getMenuId() . '-' . '0'] = 'At top of this menu';
            $pagesOptions[$menu->getMenuId()]['empty_option'] = '---Please Select a page---';
            $pagesOptions[$menu->getMenuId()]['label'] = $menu->getMenu();
            
        }
        
        /* @var $page \Navigation\Model\Entity\Page */
        foreach ($pages as $page) {
            
            $ident = ($page->getDepth() > 0) ? str_repeat('%space%%space%',($page->getDepth())) . '%bull%%space%' : '';
            
            $pagesOptions[$page->getMenuId()]['options'][$page->getMenuId() . '-' . $page->getPageId()] = $ident . $page->getLabel();
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
