<?php
namespace Shop\Form\Product;

use Application\Mapper\AbstractNestedSet as NestedSet;
use Shop\Mapper\Product\Image as ImageMapper;
use Shop\Service\Product\Category as CategoryService;
use Zend\Form\Form;

class Category extends Form
{
	/**
	 * @var CategoryService
	 */
	protected $categoryService;
	
	/**
	 * @var ImageMapper
	 */
	protected $imageMapper;
	
	/**
	 * @var int
	 */
	protected $categoryId;
	
    public function __construct()
    {
    	parent::__construct('Category From');
    	
    	$this->add(array(
    		'name'	=> 'productCategoryId',
    		'type'	=> 'hidden',
    	));
    	
    	$this->add(array(
    		'name'			=> 'category',
    		'type'			=> 'text',
    		'attributes'	=> array(
    			'placeholder'		=> 'Category:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
    		),
    		'options'		=> array(
    			'label'	=> 'Category:',
    		)
    	));
    	
    	$this->add(array(
    		'name'			=> 'ident',
    		'type'			=> 'text',
    		'attributes'	=> array(
    			'placehoder'		=> 'Ident:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'off'
    		),
    		'options'		=> array(
    			'label'			=> 'Ident:',
    			'help-inline'	=> 'If you leave this blank the the category name will be used for the ident.'
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'enabled',
    		'type'			=> 'checkbox',
    		'options'		=> array(
    			'label'			=> 'Enabled:',
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    			'required' 		=> true,
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'discontinued',
    		'type'			=> 'checkbox',
    		'options'		=> array(
    			'label'			=> 'Discontinued:',
    			'required' 		=> true,
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    		),
    	));
    }
    
    public function init()
    {
    	$this->add(array(
    		'name'		=> 'productImageId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Category Image:',
    			'required'		=> true,
    			'value_options'	=> $this->getImageList(),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'parent',
    		'type'			=> 'select',
    		'attributes'	=> array(
    			'class' => 'input-xlarge',
    		),
    		'options'		=> array(
    			'label'			=> 'Parent:',
    			'required'		=> true,
    			'value_options' => $this->getParentList()
    		),
    	));
    	
    	$categoryInsertOptions = array(
    		NestedSet::INSERT_NODE	=> 'insert after this category.',
    		NestedSet::INSERT_CHILD	=> 'insert as a new sub-category at the top.',
    		
    	);
    	
    	if ($this->getCategoryId()) {
    		$categoryInsertOptions['noInsert'] = 'no change';
    	}
    	
    	$this->add(array(
    		'name'			=> 'categoryInsertType',
    		'type'			=> 'radio',
    		'options'		=> array(
    			'required'		=> true,
    			'value_options' => array_reverse($categoryInsertOptions, true),
    		),
    	));
    }
    
    public function getParentList()
    {
    	$cats = $this->getCategoryService()->fetchAll();
    	$parentOptions = array(0 => 'Top');
    	
    	/* @var $cat \Shop\Model\Product\Category */
    	foreach($cats as $cat) {
    		$indent = 'indent' . ($cat->getDepth() + 1);
    		$parent = ($cat->hasChildren() || $cat->getDepth() == 0) ? 'bold ' : '';
    		$parentOptions[] = array(
    			'label'	=> $cat->getCategory(),
    			'value'	=> $cat->getProductCategoryId(),
    			'attributes'	=> array(
    				'class'	=> $parent . $indent,
    			)
    		);
    	}
    	
    	return $parentOptions;
    }
    
    public function getImageList()
    {
    	$id = $this->getCategoryId();
    	$imageOptions = array();
    	
    	if (!0 == $id) {
    		$ids = $this->getCategoryService()->getCategoryChildrenIds($id);
    		$images = $this->getImageMapper()->getImagesByCategoryIds($ids);
    		
    		if ($images) {
    			/* @var $image \Shop\Model\Product\Image */
    			foreach($images as $image) {
    				$imageOptions[$image->getProductImageId()] = $image->getThumbnail();
    			}
    		} else {
    			$imageOptions[0] = 'No Images Uploaded';
    		}
    	} else {
    		$imageOptions[0] = 'No Images Uploaded';
    	}
    	
    	return $imageOptions;
    }
    
    /**
     * @return number
     */
	public function getCategoryId()
	{
		return $this->categoryId;
	}
		
	/**
	 * @param int $categoryId
	 * @return \Shop\Form\Product\Category
	 */
	public function setCategoryId($categoryId)
	{
		$categoryId = (int) $categoryId;
		$this->categoryId = $categoryId;
		return $this;
	}
	
	/**
	 * @return \Shop\Service\Product\Category
	 */
	public function getCategoryService()
	{
		return $this->categoryService;
	}
	    
    /**
     * @param CategoryService $categoryService
     * @return \Shop\Form\Product\Category
     */
	public function setCategoryService(CategoryService $categoryService)
	{
		$this->categoryService = $categoryService;
		return $this;
	}
	
	/**
	 * @return \Shop\Mapper\Product\Image
	 */
	public function getImageMapper()
	{
		return $this->imageMapper;
	}
	    
    /**
     * @param ImageMapper $imageMapper
     * @return \Shop\Form\Product\Category
     */
	public function setImageMapper(ImageMapper $imageMapper)
	{
		$this->imageMapper = $imageMapper;
		return $this;
	}
	
}
