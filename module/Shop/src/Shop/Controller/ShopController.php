<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Shop for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ShopController extends AbstractController
{
    public function indexAction()
    {
    	if (!$this->isAllowed('ShopAdmin', 'view')) {
    		return $this->redirect()->toRoute('home');
    	}
    	
        return new ViewModel();
    }
    
    public function shopFrontAction()
    {
    	$cats = $this->getModel('Shop\Model\Category')->getTopLevelCategories();
    	
    	return new ViewModel(array(
			'cats' => $cats
    	));
    }
}
