<?php
namespace Shop\Service;

use Application\Service\AbstractService;
use FB;

class Product extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\Product';
	protected $form = '';
	protected $inputFilter = '';
	
	/**
	 * @var \Shop\Service\ProductCategory
	 */
	protected $categoryService;
	
	public function getProductByIdent($ident)
	{
		return $this->getMapper()->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $page=false, $count=25, $order=null, $deep=true)
	{
		if (is_string($category)) {
			$cat = $this->getCategoryService()->getCategoryByIdent($category);
			$categoryId = (null === $cat) ? 0 : $cat->getProductCategoryId();
		} else {
			$categoryId = (int) $category;
		}
	
		if (true === $deep) {
			$ids = $this->getCategoryChildrenIds(
				$categoryId, true
			);
	
			$ids[] = $categoryId;
			$categoryId = (null === $ids) ? $categoryId : $ids;
		}
	
		return $this->getMapper()
			->getProductsByCategory(
				$categoryId,
				$page,
				$count,
				$order
			);
	}
	
	public function getCategoryService()
	{
		if (!$this->categoryService) {
			$sl = $this->getServiceLocator();
			$this->categoryService = $sl->get('Shop\Service\ProductCategory');
		}
		
		return $this->categoryService;
	}
}
