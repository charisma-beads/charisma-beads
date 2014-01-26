<?php
namespace Shop\Controller\Product;

use Application\Controller\AbstractCrudController;

class ProductImage extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productImageId');
	protected $serviceName = 'Shop\Service\ProductImage';
	protected $route = 'admin/shop/image';
	
}
