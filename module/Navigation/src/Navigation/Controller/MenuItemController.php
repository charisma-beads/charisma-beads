<?php

namespace Navigation\Controller;

use Common\Controller\AbstractCrudController;
use Navigation\Service\MenuItemService;


class MenuItemController extends AbstractCrudController
{
	protected $controllerSearchOverrides = ['sort' => 'lft'];
	protected $serviceName = MenuItemService::class;
	protected $route = 'admin/menu-item';
	
	protected function setMenuId()
	{
	    $menuId = $this->params('menuId', 0);
	    $this->searchDefaultParams['menuId'] = $menuId;
	    
	    $session = $this->sessionContainer($this->getServiceName());
	    
	    $params = ($session->offsetGet('params')) ?: [];
	    
	    $params['menuId'] = $menuId;
	    
	    $session->offsetSet('params', $params);
	    
	    return $menuId;
	}
	
    public function indexAction()
    {  	
    	$menuId = $this->setMenuId();
    	
    	if (!$menuId) return $this->redirect()->toRoute('admin/menu');
    	
        $viewModel = parent::indexAction();
        
        $viewModel->setVariable('menuId', $menuId);
        
        return $viewModel;
    }
    
    public function listAction()
    {
        $menuId = $this->setMenuId();
        
        $viewModel = parent::listAction();
        
        $viewModel->setVariable('menuId', $menuId);
        
        return $viewModel;
    }
}
