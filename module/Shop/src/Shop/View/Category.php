<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;
use Shop\Service\Product\Category as ProductCategory;

class Category extends AbstractViewHelper
{
	/**
	 * @var ProductCategory
	 */
	protected $service;
	
	public function __invoke()
	{
		if (!$this->service instanceof ProductCategory) {
			$this->service = $this->getServiceLocator()
				->getServiceLocator()
				->get('Shop\Service\Product\Category');
		}
		
		return $this;
	}
	
	/**
	 * @param int $id
	 * @return \Shop\Model\Product\Category
	 */
	public function getCategory($id)
	{
		return $this->service->getById($id);
	}
	
	public function getChildCategories($id = 0)
	{
		return $this->service->fetchAll();
	}
}
