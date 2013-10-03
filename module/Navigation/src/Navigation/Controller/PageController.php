<?php

namespace Navigation\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Navigation\Form\Page as PageForm;

class PageController extends AbstractController
{
	/**
	 * @var \Navigation\Model\Mapper\Page;
	 */
	protected $pageMapper;
	
    public function listAction()
    {    	
    	$menuId = $this->params('menuId', 0);
    	
    	if (!$menuId) return $this->redirect()->toRoute('admin/menu');
    	
        return new ViewModel(array(
        	'pages' => $this->getPageMapper()->getPagesByMenuId($menuId),
        	'menuId' => $menuId
        ));
    }
    
    public function addAction()
    {
    	$menuId = $this->params('menuId', 0);
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
			$result = $this->getPageMapper()->addPage($request->getPost());
			
			if ($result instanceof PageForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result,
					'menuId' => $menuId
				));
				
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Page has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Page could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/page', array('menuId' => $menuId));
			}
		}
		
		return new ViewModel(array(
			'form' => $this->getPageMapper()->getPageForm(),
			'menuId' => $menuId
		));	
    
    }
    
    public function editAction()
    {
    	$menuId = $this->params('menuId', 0);
    
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('admin/page', array(
    			'action' => 'add',
    			'menuId' => $menuId
    		));
    	}
    
    	// Get the Page with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the list page.
    	try {
    		$page = $this->getPageMapper()->getPageById($id);
    	} catch (\Exception $e) {
    		return $this->redirect()->toRoute('admin/page', array(
    			'action' => 'list'
    		));
    	}
    
    	$request = $this->getRequest();
		if ($request->isPost()) {
			
			$result = $this->getPageMapper()->editPage($page, $request->getPost());
			
			if ($result instanceof PageForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result,
					'page' => $page,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Page has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Page could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of pages
				return $this->redirect()->toRoute('admin/page', array('menuId' => $menuId));
			}
		}
		
		return new ViewModel(array(
            'form' => $this->getPageMapper()->getPageForm()->bind($page),
            'page' => $page
        ));
    }
    
	public function deleteAction()
	{
		$request = $this->getRequest();
		
		$menuId = (int) $request->getPost('menuId');
		$id = (int) $request->getPost('pageId');
		
		if (!$id) {
			return $this->redirect()->toRoute('admin/page');
		}
		
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
		
			if ($del == 'delete') {
				$id = (int) $request->getPost('pageId');
				$result = $this->getPageMapper()->deletePage($id);
				
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Page has been deleted from the database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Page could not be deleted due to a database error.'
					);
				}
			}
		
			// Redirect to list of menu
			return $this->redirect()->toRoute('admin/page', array('menuId' => $menuId));
		}
		
		return $this->redirect()->toRoute('admin/page', array('menuId' => $menuId));
	}
	
	/**
	 * @return \Navigation\Model\Mapper\Page
	 */
	protected function getPageMapper()
	{
		if (!$this->pageMapper) {
			$sl = $this->getServiceLocator();
			$this->pageMapper = $sl->get('Navigation\Service\Page');
		}
	
		return $this->pageMapper;
	}
}
