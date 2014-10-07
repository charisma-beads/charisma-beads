<?php
namespace Shop\Controller\Customer;

use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\Form\Form;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;

class Customer extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'name');
	protected $serviceName = 'Shop\Service\Customer';
	protected $userRoute = 'shop/customer';
	protected $route = 'admin/shop/customer';

    public function listNewAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Action not allowed');
        }

        /* @var $service \Shop\Service\Customer\Customer */
        $service = $this->getService();

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel->setVariables([
            'models' => $service->getCustomersByMonth(date('m')),
        ]);
    }

    /**
     * @return array|\Zend\Http\Response
     */
	public function myDetailsAction()
	{
	    $prg = $this->prg($this->userRoute);
	    
	    /* @var $service \Shop\Service\Customer */
	    $service = $this->getService();
	    $userId = $this->identity()->getUserId();
	    
	    $customer = $service->getCustomerByUserId($userId);
	    
	    if ($prg instanceof Response) {
	    	// returned a response to redirect us
	    	return $prg;
	    } elseif ($prg === false) {
	    	// this wasn't a POST request, but there were no params in the flash messenger
	    	// probably this is the first time the form was loaded
	    	return [
	    	  'form' => $this->getService()->getForm($customer),
	    	  'model' => $customer,
            ];
	    }
	    
	    $result = $this->getService()->edit($customer, $prg);
	    
	    if ($result instanceof Form) {
	    	 
	    	$this->flashMessenger()->addInfoMessage(self::FORM_ERROR);
	    	 
	    	return [
    			'form'	=> $result,
    			'model'	=> $customer,
			];
	    }
	    
	    if ($result) {
	    	$this->flashMessenger()->addSuccessMessage('Your changes were saved.');
	    } else {
	    	$this->flashMessenger()->addErrorMessage('Your changes could not be save due to database error.');
	    }
	    
	    return $this->redirect()->toRoute($this->userRoute);
	}
}
