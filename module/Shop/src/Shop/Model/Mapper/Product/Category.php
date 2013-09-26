<?php
namespace Shop\Model\Product;

use Application\Model\AbstractModel;

class Category extends AbstractModel
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
