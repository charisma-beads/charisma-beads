<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Service\CountryProvinceService;
use Common\Controller\AbstractCrudController;
use Shop\ShopException;
use Zend\View\Model\ViewModel;

/**
 * Class CountryProvince
 *
 * @package Shop\Controller
 */
class CountryProvinceController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'countryCode');
    protected $serviceName = CountryProvinceService::class;
    protected $route = 'admin/shop/country/province';
    protected $paginate = false;
    
    public function countryProvinceListAction()
    {
    	if (!$this->getRequest()->isXmlHttpRequest()) {
    		throw new ShopException('Not Allowed');
    	}
    
    	$countryId = $this->params()->fromPost('countryId', 0);
    	
    	/* @var $service \Shop\Service\CountryProvinceService */
    	$service = $this->getService();
    	
    	$provinces = $service->getProvincesByCountryId($countryId);
        
    	$viewModel = new ViewModel([
            'models' => $provinces,
		]);
    	
    	$viewModel->setTerminal(true);
    	
    	return $viewModel;
    }
}
