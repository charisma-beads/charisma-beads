<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class ProductPriceGroupController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productGroupId');
	protected $serviceName = 'Shop\Service\ProductPriceGroup';
	protected $route = 'admin/shop/price-group';
	
}
