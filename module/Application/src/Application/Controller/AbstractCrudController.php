<?php
namespace Application\Controller;

use Exception;
use Application\Controller\AbstractController;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;


abstract class AbstractCrudController extends AbstractController
{   
    const DATABSE_SAVE_ERROR		= 'row could not be saved due to a database error.';
    const DATABASE_SAVE_SUCCESS		= 'row with id %s has been saved to database.';
    const DATABASE_DELETE_ERROR		= 'row could not be deleted due to a database error.';
    const DATABASE_DELETE_SUCCESS	= 'row with id %s has been deleted from the database.';
    const FORM_ERROR				= 'There were one or more isues with your submission. Please correct them as indicated below.';
    
    protected $searchDefaultParams;
    protected $serviceName;
    protected $service;
    protected $route;
    
    public function indexAction()
    {
    	$page = $this->params()->fromRoute('page', 1);
    		
    	return new ViewModel(array(
    		'models' => $this->getService()->usePaginator(array(
    			'limit'	=> 25,
    			'page'	=> $page
    		))->search($this->getSearchDefaultParams())
    	));
    }
    
    public function listAction()
    {
    	if (!$this->getRequest()->isXmlHttpRequest()) {
    		return $this->redirect()->toRoute($this->getRoute());
    	}
    		
    	$params = $this->params()->fromPost();
    		
    	$viewModel = new ViewModel(array(
    		'models' => $this->getService()->usePaginator(array(
    			'limit'	=> $params['count'],
    			'page'	=> $params['page']
    		))->search($params)
    	));
    		
    	$viewModel->setTerminal(true);
    		
    	return $viewModel;
    }
    
    public function addAction()
    {
    	$request = $this->getRequest();
    
    	if ($request->isPost()) {
    
    		$result = $this->getService()->add($request->getPost());
    
    		if ($result instanceof Form) {
    
    			$this->flashMessenger()->addInfoMessage(self::FORM_ERROR);
    
    			return new ViewModel(array(
    				'form' => $result
    			));
    
    		} else {
    			if ($result) {
    				$this->flashMessenger()->addSuccessMessage(self::DATABASE_SAVE_SUCCESS);
    			} else {
    				$this->flashMessenger()->addErrorMessage(self::DATABASE_DELETE_SUCCESS);
    			}
    
    			return $this->redirect()->toRoute($this->getRoute());
    		}
    	}
    
    	return new ViewModel(array(
    		'form' => $this->getService()->getForm(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute($this->getRoute(), array(
    			'action' => 'add'
    		));
    	}
    
    	try {
    		$model = $this->getService()->getById($id);
    	} catch (\Exception $e) {
    		$this->setExceptionMessages($e);
    		return $this->redirect()->toRoute($this->getRoute(), array(
    			'action' => 'list'
    		));
    	}
    
    	$request = $this->getRequest();
    
    	if ($request->isPost()) {
    
    		$result = $this->getService()->edit($model, $request->getPost());
    
    		if ($result instanceof Form) {
    
    			$this->flashMessenger()->addInfoMessage(self::FORM_ERROR);
    
    			return new ViewModel(array(
    				'form'	=> $result,
    				'model'	=> $model,
    			));
    		} else {
    			if ($result) {
    				$this->flashMessenger()->addSuccessMessage(self::DATABASE_SAVE_SUCCESS);
    			} else {
    				$this->flashMessenger()->addErrorMessage(self::DATABSE_SAVE_ERROR);
    			}
    
    			return $this->redirect()->toRoute($this->getRoute());
    		}
    	}
    
    	$form = $this->getService()->getForm($model);
    
    	return new ViewModel(array(
    		'form'	=> $form,
    		'model'	=> $model,
    	));
    }
    
    public function deleteAction()
    {
    	$request = $this->getRequest();
    
    	$pk = $this->getService()->getMapper()->getPrimaryKey();
    	$id = (int) $request->getPost($pk);
    
    	if (!$id) {
    		return $this->redirect()->toRoute($this->getRoute());
    	}
    
    	if ($request->isPost()) {
    		$del = $request->getPost('submit', 'No');
    
    		if ($del == 'delete') {
    			try {
    				$result = $this->getService()->delete($id);
    
    				if ($result) {
    					$this->flashMessenger()->addSuccessMessage(self::DATABASE_DELETE_SUCCESS);
    				} else {
    					$this->flashMessenger()->addErrorMessage(self::DATABASE_DELETE_ERROR);
    				}
    			} catch (\Exception $e) {
    				$this->setExceptionMessages($e);
    			}
    		}
    	}
    
    	return $this->redirect()->toRoute($this->getRoute());
    }
    
    protected function getServiceName()
    {
    	return $this->serviceName;
    }
    
    /**
     * @param string $service
     * @return \Application\Service\AbstractService
     */
    protected function getService($service = null)
    {
    	if (!$this->service) {
    		$service = (is_string($service)) ?: $this->getServiceName();
    		$sl = $this->getServiceLocator();
    		$this->service = $sl->get($service);
    	}
    
    	return $this->service;
    }
    
    public function getModels()
    {
    	return $this->models;
    }
    
    public function setModels($models)
    {
    	$this->models = $models;
    	return $this;
    }
    
    public function getModel()
    {
    	return $this->model;
    }
    
    public function setModel($model)
    {
    	$this->model = $model;
    	return $this;
    }
    
    public function getSearchDefaultParams()
    {
    	return $this->searchDefaultParams;
    }
    
    public function setSearchDefaultParams($searchDefaultParams)
    {
    	$this->searchDefaultParams = $searchDefaultParams;
    	return $this;
    }
    
    public function setServiceName($serviceName)
    {
    	$this->serviceName = $serviceName;
    	return $this;
    }
    
    public function getRoute()
    {
    	return $this->route;
    }
    
    public function setRoute($route)
    {
    	$this->route = $route;
    	return $this;
    }
    
    /**
     * Sets a exception message for flash plugin.
     *
     * @param Exception $exception
     */
    public function setExceptionMessages(Exception $exception)
    {
    	$this->flashMessenger()->addErrorMessage(array(
    			'message' => $exception->getMessage(),
    			'title'   => 'Error!'
    	));
    
    	$e = $exception->getPrevious();
    
    	if ($e) {
    		while ($e) {
    			$this->flashMessenger()->addMessage($e->getMessage());
    			$e = $e->getPrevious();
    		}
    	}
    }
}
