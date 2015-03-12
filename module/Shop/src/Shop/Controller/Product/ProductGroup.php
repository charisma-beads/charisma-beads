<?php
namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductGroup extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'productGroupId');
	protected $serviceName = 'ShopProductGroup';
	protected $route = 'admin/shop/group';
	
}
