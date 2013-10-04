<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class ProductCategory extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\ProductCategory';
	protected $form = '';
	protected $inputFilter = '';
	
	public function fetchAll($topLevelOnly=false)
	{
	  return $this->getMapper()->getFullTree($topLevelOnly);
	}
	
	public function getCategoriesByParentId($parentId)
	{
		$parentId = (int) $parentId;
	
		return ($parentId != 0) ? $this->getMapper()->getDecendentsByParentId($parentId) : $this->fetchAll(true);
	}
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
	
		return $this->getMapper()->getCategoryByIdent($ident);
	}
	
	public function getCategoryChildrenIds($categoryId, $recursive=false)
	{
		$categories = $this->getMapper()
			->getDecendentsByParentId($categoryId, $recursive);
		
		$cats = array();
	
		foreach ($categories as $category) {
			$cats[] = $category->getProductCategoryId();
		}
	
		return $cats;
	}
	
	public function getParentCategories($categoryId)
	{
		return $this->getMapper()->getPathwayByChildId($categoryId);
	}
}
