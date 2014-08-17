<?php
namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductImage extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productImageId');
	protected $serviceName = 'Shop\Service\Product\Image';
	protected $route = 'admin/shop/image';
	
}
