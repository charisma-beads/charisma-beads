<?php
namespace Shop\Controller\Product;

use Application\Controller\AbstractCrudController;

class ProductGroupPrice extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productGroupId');
	protected $serviceName = 'Shop\Service\ProductGroupPrice';
	protected $route = 'admin/shop/group-price';
	
}
