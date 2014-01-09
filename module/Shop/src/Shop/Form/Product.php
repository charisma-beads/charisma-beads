<?php
namespace Shop\Form;

use Zend\Form\Form;

class Product extends Form
{
    public function __construct()
    {
        parent::__construct('Product From');
        
        $this->add(array(
        	'name'	=> 'productId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'productCategoryId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'productSizeId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'taxCodeId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'postUnitId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'productGroupId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'	=> 'stockStausId',
        	'type'	=> 'hidden',
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
        		'help-inline'	=> 'If you leave this blank the the product name and short description will be used for the ident.'
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'name',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placeholder'	=> 'Product Name:',
        		'autofocus'		=> true,
        	),
        	'options'		=> array(
        		'label'		=> 'Product Name/Number:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'price',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'placeholder'		=> 'Price:',
        		'autofocus'			=> true,
        	),
        	'options'		=> array(
        		'label'			=> 'Price:',
        		'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'description',
        	'type'			=> 'textarea',
        	'attributes'	=> array(
        		'placeholder'	=> 'Product Description:',
        		'autofocus'		=> true,	
        	),
        	'options'		=> array(
        		'label'		=> 'Description:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'shortDescription',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placeholder'	=> 'Short Description:',
        		'autofocus'		=> true,
        	),
        	'options'		=> array(
        		'label'		=> 'Short Description:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'quantity',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'autofocus'	=> true,
        	),
        	'options'		=> array(
        		'label'	=> 'Quantity:',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'taxable',
        	'type'			=> 'select',
        	'options'		=> array(
        		'label'			=> 'Taxable:',
        		'required' 		=> true,
        		'empty_option'	=> '---Please select---',
        		'value_options' => array(
        			'0' => 'No',
        			'1' => 'Yes'
        		),
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'addPostage',
        	'type'			=> 'select',
        	'options'		=> array(
        		'label'			=> 'Add Postage:',
        		'required' 		=> true,
        		'empty_option'	=> '---Please select---',
        		'value_options' => array(
        			'0' => 'No',
        			'1' => 'Yes'
        		),
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'discountPercent',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'autofocus'	=> true,
        	),
        	'options'		=> array(
        		'label'	=> 'Product Discount:'
        	)
        ));
        
        $this->add(array(
        	'name' => 'hits',
        	'type' => 'hidden',
        ));
        
        $this->add(array(
        	'name'			=> 'enabled',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Enabled:',
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'discontinued',
        	'type'			=> 'select',
        	'options'		=> array(
        		'label'			=> 'Discontinued:',
        		'required' 		=> true,
        		'empty_option'	=> '---Please select---',
        		'value_options' => array(
        			'0' => 'No',
        			'1' => 'Yes'
        		),
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'vatInc',
        	'type'			=> 'select',
        	'options'		=> array(
        		'label'			=> 'Vat Included:',
        		'required' 		=> true,
        		'empty_option'	=> '---Please select---',
        		'value_options' => array(
        			'0' => 'No',
        			'1' => 'Yes'
        		),
        	),
        ));
        
        $this->add(array(
        	'name' => 'dateCreated',
        	'type' => 'hidden',
        ));
        
        $this->add(array(
        	'name' => 'dateModified',
        	'type' => 'hidden',
        ));
    }
}
