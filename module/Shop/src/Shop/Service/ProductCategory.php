<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class ProductCategory extends AbstractService
{
	/**
	 * @var \Shop\Mapper\Category
	 */
	protected $categoryMapper;
	
	public function getTopLevelCategories()
	{
		return $this->getCategoryGateway()->getFullTree(true);
	}
	
	/**
	 * @return \Shop\Mapper\Category
	 */
	protected function getCategoryGateway()
	{
		if (!$this->categoryGateway) {
			$sl = $this->getServiceLocator();
			$this->categoryGateway = $sl->get('Shop\Gateway\Category');
		}
	
		return $this->categoryGateway;
	}
}
