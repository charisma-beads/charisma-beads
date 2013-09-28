<?php
namespace Shop\Model;

use Application\Model\AbstractMapper;
use FB;

class Catalog extends AbstractMapper
{
	/**
	 * @var Shop\Model\DbTable\Product\Category
	 */
	protected $categoryGateway;
	
	/**
	 * @var Shop\Model\DbTable\Product
	 */
	protected $productGateway;
	
	public function getCategoriesByParentId($parentId)
	{
		$parentId = (int) $parentId;
	
		$categories = $this->getCategoryGateway();
		
		return ($parentId != 0) ? $categories->getDecendentsByParentId($parentId) : $categories->getFullTree(true);
	}
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
		
		return $this->getCategoryGateway()->getCategoryByIdent($ident);
	}
	
	public function getProductById($id)
	{
		$id = (int) $id;
	
		return $this->getProductGateway()->getById($id);
	}
	
	public function getProductByIdent($ident)
	{
		return $this->getGateway('product')->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $page=false, $count=25, $order=null, $deep=true)
	{
		if (is_string($category)) {
			$cat = $this->getCategoryGateway()->getCategoryByIdent($category);
			$categoryId = (null === $cat) ? 0 : $cat->productCategoryId;
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
	
		return $this->getProductGateway()
			->getProductsByCategory(
				$categoryId,
				$page,
				$count,
				$order
			);
	}
	
	public function getCategoryChildrenIds($categoryId, $recursive=false)
	{
		$categories = $this->getCategoryGateway()
			->getDecendentsByParentId($categoryId, $recursive);
		$cats = array();
	
		foreach ($categories as $category) {
			$cats[] = $category->productCategoryId;
		}
	
		return $cats;
	}
	
	public function getParentCategories($categoryId)
	{
		return $this->getCategoryGateway()->getPathwayByChildId($categoryId);
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
	
	/**
	 * @return \Shop\Model\DbTable\Product
	 */
	protected function getProductGateway()
	{
		if (!$this->productGateway) {
			$sl = $this->getServiceLocator();
			$this->productGateway = $sl->get('Shop\Gateway\Product');
		}
		
		return $this->productGateway;
	}
}
