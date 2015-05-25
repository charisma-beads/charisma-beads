<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoCommon
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace Shop\Service\Product;

use UthandoCommon\Model\ModelInterface;
use Shop\ShopException;
use Shop\Model\Product\Category as CategoryModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\Form\Form;
use Zend\EventManager\Event;

/**
 * Class Category
 * @package Shop\Service\Product
 */
class Category extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductCategory';
    
    protected $tags = [
        'product', 'image', 'option',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'productImage'  => [
            'refCol'    => 'productImageId',
            'service'   => 'ShopProductImage',
        ],
    ];
	
	/**
	 * @var \Shop\Service\Product\Image
	 */
	protected $imageService;
	
	/**
	 * Attach events
	 */
	public function attachEvents()
	{
	    $this->getEventManager()->attach([
	        'pre.form'
        ], [$this, 'preForm']);
	}

    /**
     * @param bool $topLevelOnly
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function fetchAll($topLevelOnly=false)
	{
        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();

	    if ($topLevelOnly) {
	    	$cats =  $mapper->getTopLevelCategories();
	    } else {
	    	$cats =  $mapper->getAllCategories();
	    }

        foreach($cats as $category) {
            $this->populate($category, true);
        }

        return $cats;
	}

    /**
     * @param $parentId
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function getCategoriesByParentId($parentId)
	{
		$parentId = (int) $parentId;

        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();
	
		return ($parentId != 0) ? $mapper->getSubCategoriesByParentId($parentId) : $this->fetchAll(true);
	}

    /**
     * @param string $ident
     * @return \Shop\Model\Product\Category|false
     */
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;

        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();

		$cat = $mapper->getCategoryByIdent($ident);
		
		return $cat;
	}

    /**
     * @param int $categoryId
     * @param bool $recursive
     * @return array
     */
	public function getCategoryChildrenIds($categoryId, $recursive=false)
	{
        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();

		$categories = $mapper->getSubCategoriesByParentId($categoryId, $recursive);
		
		$cats = [];

        /* @var $category \Shop\Model\Product\Category */
		foreach ($categories as $category) {
			$cats[] = $category->getProductCategoryId();
		}
	
		return $cats;
	}

    /**
     * @param int $categoryId
     * @param bool $recursive
     * @return mixed
     */
	public function getCategoryImages($categoryId, $recursive=false)
	{
		$ids = $this->getCategoryChildrenIds($categoryId, $recursive);

        /* @var $mapper \Shop\Mapper\Product\Image */
        $mapper = $this->getMapper('ShopProductImage', [
            'model'     => 'ShopProductImage',
            'hydrator'  => 'ShopProductImage',
        ]);

		$images = $mapper->getImagesByCategoryIds($ids);

		return $images;
	}

    /**
     * @param $categoryId
     * @return mixed
     */
	public function getParentCategories($categoryId)
	{
        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();

		return $mapper->getBreadCrumbs($categoryId);
	}

    /**
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function search(array $post)
	{
		foreach ($post as $key => $value) {
			if ($key == 'category') {
				$key = preg_replace('(\w+)', 'child.$0', $key);
				$post[$key] = $value;
				unset($post['category']);
			}
		}
		
		return parent::search($post);
	}

    /**
     * @param array $post
     * @param Form $form
     * @return int|Form
     */
	public function add(array $post, Form $form = null)
	{
		if (!$post['ident']) {
			$post['ident'] = $post['category'];
		}

        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();

        /* @var $model \Shop\Model\Product\Category */
		$model = $mapper->getModel();

        $options = [
            'categoryId' => $model->getProductCategoryId(),
        ];

		$form  = $this->getForm($model, $post, $options, true, true);
	
		if (!$form->isValid()) {
			return $form;
		}
	
		$data = $mapper->extract($form->getData());

        $pk = $this->getMapper()->getPrimaryKey();
        unset($data[$pk]);

		$position = (int) $post['parent'];
		$insertType = (string) $post['categoryInsertType'];
	
		$result = $mapper->insertRow($data, $position, $insertType);
		
		return $result;
	}

    /**
     * @param CategoryModel|ModelInterface $model
     * @param array $post
     * @param Form $form
     * @throws ShopException
     * @throws \UthandoCommon\Service\ServiceException
     * @return int|Form
     */
	public function edit(ModelInterface $model, array $post, Form $form = null)
	{
		if (!$model instanceof CategoryModel) {
			throw new ShopException('$model must be an instance of Shop\Model\Product\Category, ' . get_class($model) . ' given.');
		}
		
		if (!$post['ident']) {
			$post['ident'] = $post['category'];
		}

		$model->setDateModified();
        $options = [
            'categoryId' => $model->getProductCategoryId(),
        ];
		
		$form = $this->getForm($model, $post, $options, true, true);
	
		if (!$form->isValid()) {
			return $form;
		}
		
		$category = $this->getById($model->getProductCategoryId());
		
		$data = $this->getMapper()
            ->extract($form->getData());
	
		if ($category) {
			if ('noInsert' !== $post['categoryInsertType']) {

                $position = (int) $post['parent'];
                $insertType = (string) $post['categoryInsertType'];

                $result = $this->getMapper()->move($data, $position, $insertType);

			} else {
				$result = $this->save($model);
			}
			$this->removeCacheItem($model->getProductCategoryId());
		} else {
			throw new ShopException('Product Category id does not exist');
		}
		
		// cascade enabled and/or discontinued if needed.
		if ($result) {
		    $ids = $this->getCategoryChildrenIds($category->getProductCategoryId(), true);
		    $ids[] = $category->getProductCategoryId();
		    
		    if ($data['enabled'] != (int) $category->getEnabled()) {
		        $this->getMapper()->toggleEnabled($category->setEnabled((bool) $data['enabled']));
		        $this->getMapper()->cascadeEnabled($ids, $data['enabled']);
		    }
		    
		    if ($data['discontinued'] != (int) $category->getDiscontinued()) {
		        $this->getMapper()->toggleDiscontinued($category->setDiscontinued((bool) $data['discontinued']));
		        $this->getMapper()->cascadeDiscontinued($ids, $data['discontinued']);
		    }
		    
		    $this->removeCacheItem($model->getProductCategoryId());
		}
	
		return $result;
	}

	public function delete($id)
	{
		$id = (int) $id;
		$childIds = $this->getCategoryChildrenIds($id);

		foreach ($childIds as $catId) {
			$this->removeCacheItem($catId);
		}

		return parent::delete($id);
	}

    /**
     * @param CategoryModel $category
     * @return mixed
     * @throws ShopException
     */
	public function toggleEnabled(CategoryModel $category)
	{	
		//check for parent and if it's enabled or not, if disabled don't update.
		$parents = $this->getParentCategories(
            $category->getProductCategoryId()
        )->toArray();
		
		$this->removeCacheItem($category->getProductCategoryId());
		
		array_pop($parents);
		$parent = array_slice($parents, -1, 1);
		
		if (count($parent) && !$parent[0]['enabled']) {
			throw new ShopException("Can't change enabled status on child while parent is disabled. First enable the parent category");
		}

		if (true === $category->isEnabled()) {
			$category->setEnabled(false);
		} else {
			$category->setEnabled(true);
		}
		
		$category->setDateModified();

        /* @var $mapper \Shop\Mapper\Product\Category */
        $mapper = $this->getMapper();
		
		$result = $mapper->toggleEnabled($category);
		
		if ($result) {
		    $ids = $this->getCategoryChildrenIds($category->getProductCategoryId(), true);
		    $ids[] = $category->getProductCategoryId();
		    $mapper->cascadeEnabled($ids, $category->getEnabled());
		}
		
		return $result;
	}
	
	public function preForm(Event $e)
	{
	    $model = $e->getParam('model');
        
	    if ($model instanceof CategoryModel) {
	        $this->setFormOptions([
	            'productCategoryId' => $model->getProductCategoryId(),
	        ]);
	    }
	}
}
