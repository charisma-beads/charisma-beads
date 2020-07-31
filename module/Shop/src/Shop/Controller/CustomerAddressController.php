<?php

namespace Shop\Controller;

use Exception;
use Shop\Service\CustomerAddressService;
use Shop\Service\CustomerService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Laminas\Form\Form;
use Laminas\View\Model\ViewModel;

/**
 * Class CustomerAddress
 *
 * @package Shop\Controller
 */
class CustomerAddressController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'postcode');
    protected $serviceName = CustomerAddressService::class;
    protected $userRoute = 'shop/customer/address';
    protected $route = 'admin/shop/customer/address';
    protected $paginate = false;

    public function addressListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $customer = $this->params()->fromPost('customerId', 0);

        /* @var $service \Shop\Service\CustomerAddressService */
        $service = $this->getService();

        $addresses = $service->getAllAddressesByCustomerId($customer);

        $viewModel = new ViewModel([
            'models' => $addresses,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
    
    public function myAddressesAction()
    {
        /* @var $service \Shop\Service\CustomerAddressService */
        $service = $this->getService();
        $addresses = $service->getAllUserAddresses($this->getUserId());
        
        return ['addresses' => $addresses];
    }
    
    public function addAddressAction()
    {
        $request = $this->getRequest();
        $user = $this->identity();
        
        if ($request->isPost()) {
        	try {
        		$params = $this->params()->fromPost();
        		$customerId = $this->getService(CustomerService::class)
                    ->getCustomerByUserId($user->getUserId())
                    ->getCustomerId();
        		
        		$params['customerId'] = $customerId;
        		
        		$result = $this->getService()->add($params);
        	  
        		if ($result instanceof Form) {
        			 
        			$this->flashMessenger()->addInfoMessage(self::FORM_ERROR);
        			 
        			return new ViewModel([
        				'form' => $result,
        			]);
        			 
        		} else {
        			if ($result) {
        				$this->flashMessenger()->addSuccessMessage('Your changes were saved.');
        			} else {
        				$this->flashMessenger()->addErrorMessage('Your changes could not be save due to database error.');
        			}
        			 
        			return $this->redirect()->toRoute($this->userRoute);
        		}
        	} catch (Exception $e) {
        		$this->setExceptionMessages($e);
        		return $this->redirect()->toRoute($this->userRoute);
        	}
        }
        
        return new ViewModel([
        	'form' => $this->getService()->getForm(),
        ]);
    }
    
    public function editAddressAction()
    {
        $request = $this->getRequest();
        
        $id = (int) $this->params('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute($this->userRoute);
    	}
    	
    	$viewModel = new ViewModel();
    
    	try {
    		$model = $this->getService()->getById($id);
    		$customerId = $this->getService(CustomerService::class)
        		->getCustomerByUserId($this->getUserId())
        		->getCustomerId();
    		
    		// make sure user is allowed to edit this address.
    		if ($model->getCustomerId() != $customerId) {
    		    return $this->redirect()->toRoute($this->userRoute); 
    		}

	    	if ($request->isPost()) {
	    		
	    		// primary key ids must match. If not throw exception.
	    		$pk = $this->getService()->getMapper()->getPrimaryKey();
	    		$modelMethod = 'get' . ucwords($pk);
	    		$post = $this->params()->fromPost();
	    		
	    		if ($post[$pk] != $model->$modelMethod()) {
	    			throw new Exception('Primary keys do not match.');
	    		}
	    
	    		$result = $this->getService()->edit($model, $post);
	    
	    		if ($result instanceof Form) {
	    
	    			$this->flashMessenger()->addInfoMessage(self::FORM_ERROR);
	    
	    			return $viewModel->setVariables([
	    				'form'	=> $result,
	    				'model'	=> $model,
	    			]);
	    		} else {
	    			if ($result) {
	    				$this->flashMessenger()->addSuccessMessage('Your changes were saved.');
	    			} else {
	    				$this->flashMessenger()->addErrorMessage('Your changes could not be save due to database error.');
	    			}

                    if ($post['returnTo']) {
                        return $this->redirect()->toUrl($post['returnTo']);
                    }
	                
	    			return $this->redirect()->toRoute($this->userRoute);
	    		}
	    	}
	    	
	    	$form = $this->getService()->prepareForm($model);
            $form->get('returnTo')->setValue(html_entity_decode($this->params('return', null)));
	    	
    	} catch (Exception $e) {
    		$this->setExceptionMessages($e);
    		return $this->redirect()->toRoute($this->userRoute);
    	}
    
    	return $viewModel->setVariables([
    		'form'	=> $form,
    		'model'	=> $model,
    	]);
    }
    
    public function deleteAddressAction()
    {
        $request = $this->getRequest();
    
    	$id = $request->getPost('customerAddressId', 0);
    
    	if (!$id) {
    		return $this->redirect()->toRoute($this->userRoute);
    	}
    	
    	$model = $this->getService()->getById($id);
    	$customerId = $this->getService(CustomerService::class)
    	   ->getCustomerByUserId($this->getUserId())
    	   ->getCustomerId();
    	
    	// make sure user is allowed to delete this address.
    	if ($model->getCustomerId() != $customerId) {
    		return $this->redirect()->toRoute($this->userRoute);
    	}
    
    	if ($request->isPost()) {
    		$del = $request->getPost('submit');
    
    		if ($del == 'deleteAddress') {
    			try {
    				$result = $this->getService()->delete($id);
    
    				if ($result) {
    					$this->flashMessenger()->addSuccessMessage('Address deleted.');
    				} else {
    					$this->flashMessenger()->addErrorMessage('Sorry, we could not delete your address at this time. Please try again later.');
    				}
    			} catch (Exception $e) {
    				$this->setExceptionMessages($e);
    			}
    		}
    	}
    
    	return $this->redirect()->toRoute($this->userRoute);
    }
    
    /**
     * @return string
     */
    private function getUserId()
    {
        return $this->identity()->getUserId();
    }
    
}
