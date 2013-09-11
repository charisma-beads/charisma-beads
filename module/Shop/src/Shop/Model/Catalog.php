<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class Catalog extends AbstractModel
{
	protected $classMap = array(
		'gateways'	=> array(
			'product'	=> 'Shop\Model\DbTable\Product',
			'category'	=> 'Shop\Model\DbTable\Product\Category',
		),
		'entities'	=> array(
			'product'	=> 'Shop\Model\Entity\Product',
			'category'	=> 'Shop\Model\Entity\Product\Category',
		),
		'forms'		=> array(
			
		),
	);
	
	public function getCategoriesByParentId($parentId)
	{
		$parentId = (int) $parentId;
	
		$categories = ($parentId != 0) ? $this->getGateway('category')
			->getCategoriesByParentId($parentId) : $this->getGateway('category')->fetchAll();
	
		return $categories;
	}
	
	public function getCategoryByIdent($ident)
	{
		return $this->getGateway('category')
			->getCategoryByIdent($ident);
	}
	
	public function getProductById($id)
	{
		$id = (int) $id;
	
		return $this->getGateway('product')->getById($id);
	}
	
	public function getProductByIdent($ident)
	{
		return $this->getGateway('product')
			->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $page=false, $count=25, $order=null, $deep=true)
	{
		if (is_string($category)) {
			$cat = $this->getGateway('category')->getCategoryByIdent($category);
			$categoryId = (null === $cat) ? 0 : $cat->categoryId;
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
	
		return $this->getGateway('product')
			->getProductsByCategory(
				$categoryId,
				$page,
				$count,
				$order
			);
	}
	
	public function getCategoryChildrenIds($categoryId, $recursive=false)
	{
		$categories = $this->getGateway('category')
			->getDecendentsByParentId($categoryId, $recursive);
		$cats = array();
	
		foreach ($categories as $category) {
			$cats[] = $category->categoryId;
		}
	
		return $cats;
	}
	
	public function getParentCategories($category)
	{
		return $category->getPathway();
	}
}
