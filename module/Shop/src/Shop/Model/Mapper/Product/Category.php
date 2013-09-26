<?php
namespace Shop\Model\Mapper\Product;

use Application\Model\AbstractMapper;

class Category extends AbstractMapper
{
	/**
	 * @var \Shop\Model\DbTable\Product\Category
	 */
	protected $categoryGateway;
	
	public function getTopLevelCategories()
	{
		return $this->getCategoryGateway()->getFullTree(true);
	}
	
	/**
	 * @return \Shop\Model\DbTable\Product\Category
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
