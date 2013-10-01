<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractController
{
	/**
	 * @var \Shop\Service\Product
	 */
	protected $productService;
	
	public function viewAction()
	{
		return new ViewModel();
	}
	
	/**
	 * @return \Shop\Service\Product
	 */
	protected function getPorductService()
	{
		if (!$this->productService) {
			$this->productService = $this->get('Shop\Service\Product');
		}
	
		return $this->productService;
	}
}
