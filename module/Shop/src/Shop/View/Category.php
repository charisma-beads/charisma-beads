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

use UthandoCommon\View\AbstractViewHelper;
use Shop\Service\Product\Category as ProductCategory;

/**
 * Class Category
 *
 * @package Shop\View
 */
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
				->get('UthandoServiceManager')
				->get('ShopProductCategory');
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
	
	public function getChildCategories()
	{
		return $this->service->fetchAll();
	}
}
