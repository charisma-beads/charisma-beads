<?php
namespace Shop\Form\Product;

use UthandoCommon\Mapper\AbstractNestedSet as NestedSet;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Category extends Form implements ServiceLocatorAwareInterface
{	
    use ServiceLocatorAwareTrait;
   
	/**
	 * @var int
	 */
	protected $categoryId;

    /**
     * @param array|\Traversable $options
     * @return \Zend\Form\Element|\Zend\Form\ElementInterface
     */
    public function setOptions($options)
    {
        if (isset($options['productCategoryId'])) {
            $this->categoryId = $options['productCategoryId'];
        }

        return parent::setOptions($options);
    }
	
    public function init()
    {
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
    			'placeholder'		=> 'Ident:',
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
    			'label'			=> 'Enabled',
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
    			'label'			=> 'Discontinued',
    			'required' 		=> true,
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    		),
    	));
    	
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
    		$categoryInsertOptions['noInsert'] = [
                'value' => 'noInsert',
                'selected' => true,
                'label' => 'no change',
    		];
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
    				'class'	=> $parent,
					'style' => 'text-indent:' . $cat->getDepth() . 'em;',
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
    		$images = $this->getCategoryService()
                ->getCategoryImages($id);
    		
    		if ($images->count() > 0) {

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
		return $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopProductCategory');
	}
}
