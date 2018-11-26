<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Shop\Service\ProductCategoryService;
use UthandoCommon\Service\ServiceManager;
use UthandoCommon\View\AbstractViewHelper;

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
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function getTopCategories()
    {
        return $this->service->fetchAll(true);
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function getChildCategories()
	{
		return $this->service->fetchAll();
	}
}
