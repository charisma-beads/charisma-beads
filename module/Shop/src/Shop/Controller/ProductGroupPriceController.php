<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class ProductGroupPriceController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productGroupId');
	protected $serviceName = 'Shop\Service\ProductGroupPrice';
	protected $route = 'admin/shop/group-price';
	
}
