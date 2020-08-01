<?php

namespace Shop\View;

use Shop\Service\ProductCategoryService;
use Common\Service\ServiceManager;
use Common\View\AbstractViewHelper;

/**
 * Class Category
 *
 * @package Shop\View
 */
class Category extends AbstractViewHelper
{
	/**
	 * @var ProductCategoryService
	 */
	protected $service;
	
	public function __invoke()
	{
		if (!$this->service instanceof ProductCategoryService) {
			$this->service = $this->getServiceLocator()
				->getServiceLocator()
				->get(ServiceManager::class)
				->get(ProductCategoryService::class);
		}
		
		return $this;
	}
	
	/**
	 * @param int $id
	 * @return \Shop\Model\ProductCategoryModel
	 */
	public function getCategory($id)
	{
		return $this->service->getById($id);
	}

    /**
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function getTopCategories()
    {
        return $this->service->fetchAll(true);
    }

    /**
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function getChildCategories()
	{
		return $this->service->fetchAll();
	}
}
