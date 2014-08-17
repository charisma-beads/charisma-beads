<?php
namespace Shop\Controller\Country;

use UthandoCommon\Controller\AbstractCrudController;
use Shop\ShopException;
use Zend\View\Model\ViewModel;

class CountryProvince extends AbstractCrudController
{
    protected $searchDefaultParams = array('sort' => 'countryCode');
    protected $serviceName = 'Shop\Service\Country\Province';
    protected $route = 'admin/shop/country/province';
    
    public function countryProvinceListAction()
    {
    	if (!$this->getRequest()->isXmlHttpRequest()) {
    		throw new ShopException('Not Allowed');
    	}
    
    	$countryId = $this->params()->fromPost('countryId', 0);
    	
    	/* @var $service \Shop\Service\Country\Province */
    	$service = $this->getService();
    	
    	$provices = $service->getProvincesByCountryId($countryId);
        
    	$viewModel = new ViewModel([
            'models' => $provices,
		]);
    	
    	$viewModel->setTerminal(true);
    	
    	return $viewModel;
    	
    }
}
