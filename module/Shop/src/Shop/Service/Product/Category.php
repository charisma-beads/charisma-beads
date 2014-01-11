<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;
use Shop\Model\Product\Category as CategoryModel;

class Category extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\ProductCategory';
	protected $form = 'Shop\Form\ProductCategory';
	protected $inputFilter = 'Shop\InputFilter\ProductCategory';
	
	public function fetchAll($topLevelOnly=false)
	{
	    if ($topLevelOnly) {
	    	return $this->getMapper()->getTopLevelCategories();
	    } else {
	    	return $this->getMapper()->getAllCategories();
	    }
	}
	
	public function searchCategories(array $post)
	{
	    $category = (isset($post['category'])) ? (string) $post['category'] : '';
	    $sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	    
		return $this->getMapper()->searchCategories($category, $sort);
	}
	
	public function getCategoriesByParentId($parentId)
	{
		$parentId = (int) $parentId;
	
		return ($parentId != 0) ? $this->getMapper()->getSubCategoriesByParentId($parentId) : $this->fetchAll(true);
	}
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
	
		return $this->getMapper()->getCategoryByIdent($ident);
	}
	
	public function getCategoryChildrenIds($categoryId, $recursive=false)
	{
		$categories = $this->getMapper()
			->getSubCategoriesByParentId($categoryId, $recursive);
		
		$cats = array();
	
		foreach ($categories as $category) {
			$cats[] = $category->getProductCategoryId();
		}
	
		return $cats;
	}
	
	public function getParentCategories($categoryId)
	{
		return $this->getMapper()->getBreadCrumbs($categoryId);
	}
	
	public function editCategory(CategoryModel $category, $post)
	{
		$category->setDateModified();
		
		return $this->edit($category, $post);
	}
}
