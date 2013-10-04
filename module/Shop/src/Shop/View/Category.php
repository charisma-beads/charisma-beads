<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;

class Category extends AbstractViewHelper
{
	/**
	 * @var Shop\Service\ProductCategory
	 */
	protected $service;
	
	public function __invoke()
	{
		$this->service = $this->getServiceLocator()
			->getServiceLocator()
			->get('Shop\Service\ProductCategory');
		
		return $this;
	}
	
	public function getChildCategories($id = 0)
	{
		return $this->service->getCategoriesByParentId($id);
	}
}
