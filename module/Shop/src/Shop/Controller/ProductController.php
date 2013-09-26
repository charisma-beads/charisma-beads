<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractController
{
	/**
	 * @var \Shop\Model\Mapper\Product
	 */
	protected $productMapper;
	
	public function viewAction()
	{
		return new ViewModel();
	}
	
	/**
	 * @return \Shop\Model\Mapper\Product
	 */
	protected function getProductMapper()
	{
		if (!$this->productMapper) {
			$this->productMapper = $this->get('Shop\Mapper\Product');
		}
	
		return $this->productMapper;
	}
}
