<?php
namespace Shop\Controller\Post;

use Application\Controller\AbstractCrudController;

class PostUnit extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postUnit');
	protected $serviceName = 'Shop\Service\PostUnit';
	protected $route = 'admin/shop/post/unit';
}
