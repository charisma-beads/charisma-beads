<?php
namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductGroupPrice extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productGroupId');
	protected $serviceName = 'Shop\Service\Product\GroupPrice';
	protected $route = 'admin/shop/group-price';
	
}
