<?php
namespace Shop\Form\Product;

use Zend\Form\Form;

class Product extends Form
{	
    public function init()
    {
        $this->add([
        	'name'	=> 'productId',
        	'type'	=> 'hidden',
        ]);

		$this->add([
			'name'      => 'redirectToEdit',
			'type'      => 'hidden',
			'attributes'   => [
				'value' => true,
			],
		]);
        
        $this->add([
        	'name'			=> 'ident',
        	'type'			=> 'text',
        	'attributes'	=> [
        		'placeholder'		=> 'Ident:',
        		'autofocus'			=> true,
        		'autocapitalize'	=> 'off'
        	],
        	'options'		=> [
        		'label'			=> 'Ident:',
        	],
        ]);
        
        $this->add([
            'name'			=> 'sku',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Product Code/SKU:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Product Code/SKU:',
                'required'	=> false,
            ],
        ]);
        
        $this->add([
        	'name'			=> 'name',
        	'type'			=> 'text',
        	'attributes'	=> [
        		'placeholder'	=> 'Product Name/Title:',
        		'autofocus'		=> true,
        	],
        	'options'		=> [
        		'label'		=> 'Product Name/Title:',
        		'required'	=> true,
        	],
        ]);
        
        $this->add([
        	'name'			=> 'price',
        	'type'			=> 'number',
        	'attributes'	=> [
        		'placeholder'	=> 'Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	],
        	'options'		=> [
        		'label'			=> 'Price:',
        		'required'		=> true,
        	],
        ]);
        
        $this->add([
        	'name'			=> 'description',
        	'type'			=> 'textarea',
        	'attributes'	=> [
        		'placeholder'	=> 'Product Description:',
        		'autofocus'		=> true,
				'class'			=> 'form-control',
				'id'			=> 'product-textarea'
        	],
        	'options'		=> [
        		'label'		=> 'Description:',
        		'required'	=> true,
        	],
        ]);
        
        $this->add([
        	'name'			=> 'shortDescription',
        	'type'			=> 'text',
        	'attributes'	=> [
        		'placeholder'	=> 'Short Description:',
        		'autofocus'		=> true,
        	],
        	'options'		=> [
        		'label'		=> 'Short Description:',
        		'required'	=> false,
        	],
        ]);
        
        $this->add([
        	'name'			=> 'quantity',
        	'type'			=> 'number',
        	'attributes'	=> [
        		'autofocus'	=> true,
        		'min'		=> '-1',
        		'step'		=> '1',
        	    'value'     => '-1',
        	],
        	'options'		=> [
        		'label'	=> 'Quantity:',
        	],
            
        ]);
        
        $this->add([
        	'name'			=> 'addPostage',
        	'type'			=> 'checkbox',
        	'options'		=> [
        		'label'			=> 'Add Postage',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	],
        ]);
        
        $this->add([
        	'name'			=> 'discountPercent',
        	'type'			=> 'number',
        	'attributes'	=> [
        		'autofocus'	=> true,
        		'min'		=> '0.00',
        		'max'		=> '100.00',
        		'step'		=> '0.01',
        	    'value'     => '0',
        	],
        	'options'		=> [
        		'label'			=> 'Product Discount:',
        	]
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
        	'name'			=> 'vatInc',
        	'type'			=> 'checkbox',
        	'options'		=> [
        		'label'			=> 'Vat Included',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	],
        ]);
        
        $this->add(array(
            'name'			=> 'showImage',
            'type'			=> 'checkbox',
            'options'		=> array(
                'label'			=> 'Show Image',
                'required' 		=> true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ),
        ));
    		
    	$this->add([
    		'name'		=> 'productCategoryId',
    		'type'		=> 'ProductCategoryList',
    		'options'	=> [
    			'label'			=> 'Category:',
    			'required'		=> true,
    		],
    	]);
    	
    	$this->add([
    		'name'		=> 'productSizeId',
    		'type'		=> 'ProductSizeList',
    		'options'	=> [
    			'label'			=> 'Size:',
    			'required'		=> true,
    		],
    	]);
    	
    	$this->add([
    		'name'		=> 'postUnitId',
    		'type'		=> 'PostUnitList',
    		'options'	=> [
    			'label'			=> 'Weight:',
    			'required'		=> true,
    		],
    	]);
    	
    	$this->add([
    		'name'		=> 'productGroupId',
    		'type'		=> 'ProductGroupList',
    		'options'	=> [
    			'label'			=> 'Price Group:',
    			'required'		=> true,
    		],
    	]);
    	
    	$this->add([
    		'name'		=> 'taxCodeId',
    		'type'		=> 'TaxCodeList',
    		'options'	=> [
    			'label'			=> 'Tax Code:',
    			'required'		=> true,
    		],
    	]);
    }
}
