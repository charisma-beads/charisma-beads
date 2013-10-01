<?php

namespace Navigation\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Navigation\Form\Menu as MenuForm;

class MenuController extends AbstractController
{
	/**
	 * @var \Navigation\Model\Mapper\Menu;
	 */
	protected $menuMapper;
	
    public function listAction()
    {
    	if (!$this->isAllowed('Menu', 'view')) {
    		return $this->redirect()->toRoute('home');
    	}
    	
        return new ViewModel(array(
        	'menus' => $this->getMenuMapper()->fetchAllMenus()
        ));
    }
    
	public function addAction()
	{
		if (!$this->isAllowed('Menu', 'add')) {
			return $this->redirect()->toRoute('home');
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$result = $this->getMenuMapper()->addMenu($request->getPost());
			
			if ($result instanceof MenuForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result
				));
				
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Menu has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Menu could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/menu');
			}
		}
		
		return new ViewModel(array(
			'form' => $this->getMenuMapper()->getMenuForm()
		));	
	}
	
	public function editAction()
	{
		if (!$this->isAllowed('Menu', 'edit')) {
			return $this->redirect()->toRoute('home');
		}
		
		$this->layout('layout/admin');
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/menu', array(
				'action' => 'add'
			));
		}
		
		// Get the Article with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$menu = $this->getMenuMapper()->getMenuById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/menu', array(
				'action' => 'list'
			));
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			
			$result = $this->getMenuMapper()->editMenu($menu, $request->getPost());
			
			if ($result instanceof MenuForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result,
					'menu' => $menu,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Menu has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Menu could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/menu');
			}
		}
		
		return new ViewModel(array(
            'form' => $this->getMenuMapper()->getMenuForm()->bind($menu),
            'menu' => $menu
        ));
	}
	
	public function deleteAction()
	{
		if (!$this->isAllowed('Menu', 'delete')) {
			return $this->redirect()->toRoute('home');
		}
		
		$request = $this->getRequest();
		
		$id = (int) $request->getPost('menuId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/menu');
		}
		
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
		
			if ($del == 'delete') {
				try {
					$id = (int) $request->getPost('menuId');
					$result = $this->getMenuMapper()->deleteMenu($id);
				
					if ($result) {
						$this->flashMessenger()->addSuccessMessage(
							'Menu has been deleted from the database.'
						);
					} else {
						$this->flashMessenger()->addErrorMessage(
							'Menu could not be deleted due to a database error.'
						);
					}
				} catch (\Exception $e) {
					$this->setExceptionMessages($e);
				}
			}
		
			// Redirect to list of menu
			return $this->redirect()->toRoute('admin/menu');
		}
		
		return $this->redirect()->toRoute('admin/menu');
	}
	
	/**
	 * @return \Navigation\Model\Mapper\Menu
	 */
	protected function getMenuMapper()
	{
		if (!$this->menuMapper) {
			$sl = $this->getServiceLocator();
			$this->menuMapper = $sl->get('Navigation\Service\Menu');
		}
		
		return $this->menuMapper;
	}
}
