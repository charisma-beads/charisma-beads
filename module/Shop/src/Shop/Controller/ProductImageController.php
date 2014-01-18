<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class ProductImageController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productImageId');
	protected $serviceName = 'Shop\Service\ProductImage';
	protected $route = 'admin/shop/image';
	
}
