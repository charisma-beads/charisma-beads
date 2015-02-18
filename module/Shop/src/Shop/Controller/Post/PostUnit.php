<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostUnit extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postUnit');
	protected $serviceName = 'ShopPostUnit';
	protected $route = 'admin/shop/post/unit';
}
