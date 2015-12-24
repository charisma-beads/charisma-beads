<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Product;

use UthandoCommon\Mapper\AbstractNestedSet as NestedSet;
use Zend\Form\Form;
use Zend\Form\FormElementManager;

/**
 * Class Category
 *
 * @package Shop\Form\Product
 * @method FormElementManager getServiceLocator()
 */
class Category extends Form
{
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
    	$this->add([
    		'name'	=> 'productCategoryId',
    		'type'	=> 'hidden',
        ]);
    	
    	$this->add([
    		'name'			=> 'category',
    		'type'			=> 'text',
    		'attributes'	=> [
    			'placeholder'		=> 'Category',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
            ],
    		'options'		=> [
    			'label'	=> 'Category',
            ]
        ]);
    	
    	$this->add([
    		'name'			=> 'ident',
    		'type'			=> 'text',
    		'attributes'	=> [
    			'placeholder'		=> 'Ident',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'off'
            ],
    		'options'		=> [
    			'label'			=> 'Ident',
    			'help-inline'	=> 'If you leave this blank the the category name will be used for the ident.'
            ],
        ]);
    	
    	$this->add([
    		'name'			=> 'enabled',
    		'type'			=> 'checkbox',
    		'options'		=> [
    			'label'			=> 'Enabled',
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    			'required' 		=> true,
            ],
        ]);
    	
    	$this->add([
    		'name'			=> 'discontinued',
    		'type'			=> 'checkbox',
    		'options'		=> [
    			'label'			=> 'Discontinued',
    			'required' 		=> true,
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
            ],
        ]);
    	
    	$this->add([
    	    'name'			=> 'showImage',
    	    'type'			=> 'checkbox',
    	    'options'		=> [
    	        'label'			=> 'Show Image',
    	        'required' 		=> true,
    	        'use_hidden_element' => true,
    	        'checked_value' => '1',
    	        'unchecked_value' => '0',
            ],
        ]);
    	
    	$this->add([
    		'name'		=> 'image',
    		'type'		=> 'text',
    		'options'	=> [
    			'label'			=> 'Image',
    			'required'		=> false,
            ],
            'attributes' => [
                'id' => 'product-category-image',
            ]
        ]);
    	
    	$this->add([
    		'name'			=> 'parent',
    		'type'			=> 'ProductCategoryList',
    		'attributes'	=> [
    			'class' => 'input-xlarge',
            ],
    		'options'		=> [
    			'label'			=> 'Parent',
    			'required'		=> false,
                'add_top'       => true,
            ],
        ]);
    	
    	$categoryInsertOptions = [
    		NestedSet::INSERT_NODE	=> 'insert after this category.',
    		NestedSet::INSERT_CHILD	=> 'insert as a new sub-category at the top.',

        ];
    	
    	if ($this->getCategoryId()) {
    		$categoryInsertOptions['noInsert'] = [
                'value' => 'noInsert',
                'selected' => true,
                'label' => 'no change',
    		];
    	}
    	
    	$this->add([
    		'name'			=> 'categoryInsertType',
    		'type'			=> 'radio',
    		'options'		=> [
    			'required'		=> true,
    			'value_options' => array_reverse($categoryInsertOptions, true),
            ],
        ]);
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
}
