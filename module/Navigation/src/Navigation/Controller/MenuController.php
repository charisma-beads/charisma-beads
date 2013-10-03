<?php

namespace Navigation\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Navigation\Form\Menu as MenuForm;

class MenuController extends AbstractController
{
	/**
	 * @var \Navigation\Service\Menu;
	 */
	protected $menuService;
	
    public function listAction()
    {	
        return new ViewModel(array(
        	'menus' => $this->getMenuService()->fetchAll()
        ));
    }
    
	public function addAction()
	{
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$result = $this->getMenuService()->add($request->getPost());
			
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
			'form' => $this->getMenuService()->getForm()
		));	
	}
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/menu', array(
				'action' => 'add'
			));
		}
		
		// Get the Article with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$menu = $this->getMenuService()->getById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/menu', array(
				'action' => 'list'
			));
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			
			$result = $this->getMenuService()->edit($menu, $request->getPost());
			
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
            'form' => $this->getMenuService()->getMenuForm($menu),
            'menu' => $menu
        ));
	}
	
	public function deleteAction()
	{
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
					$result = $this->getMenuService()->delete($id);
				
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
	 * @return \Navigation\Service\Menu
	 */
	protected function getMenuService()
	{
		if (!$this->menuService) {
			$sl = $this->getServiceLocator();
			$this->menuService = $sl->get('Navigation\Service\Menu');
		}
		
		return $this->menuService;
	}
}
