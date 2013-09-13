<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;

class Category extends AbstractViewHelper
{
	/**
	 * @var Shop\Model\Catalog
	 */
	protected $model;
	
	public function __invoke()
	{
		$this->model = $this->getServiceLocator()
			->getServiceLocator()
			->get('Shop\Model\Catalog');
		
		return $this;
	}
	
	public function getChildCategories($id = 0)
	{
		return $this->model->getCategoriesByParentId($id);
	}
}
