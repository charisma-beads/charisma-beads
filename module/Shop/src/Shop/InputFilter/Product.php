<?php
namespace Shop\InputFilter;

use Zend\InputFilter\InputFilter;

class Product extends InputFilter
{
    public function __construct()
    {
    	$this->add(array(
    		'name'       => 'ident',
    		'required'   => true,
    		'filters'    => array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    			array('name' => 'Application\Filter\Slug')
    		),
    		'validators' => array(
    			array('name' => 'StringLength', 'options' => array(
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'       => 'name',
    		'required'   => true,
    		'filters'    => array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    			array('name' => 'Application\Filter\Ucwords'),
    		),
    		'validators' => array(
    			array('name' => 'StringLength', 'options' => array(
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'price',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim')
    		),
    		'validators'	=> array(
    			array('name' => 'Float')
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'description',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name'	=> 'StringTrim')
    		),
    		'validators'	=> array(
    			array('name' => 'NotEmpty'),
    		)
    	));
    	
    	$this->add(array(
    		'name'			=> 'shortDescription',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name'	=> 'StripTags'),
    			array('name'	=> 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'NotEmpty'),
    			array('name' => 'StringLength', 'options' => array(
    				'encoding'	=> 'UTF-8',
    				'max'		=> 255
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'quantity',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name'	=> 'StripTags'),
    			array('name'	=> 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'NotEmpty'),
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options'	=> array(
    				'min'		=> -1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'taxable',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'addPostage',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'discountPercent',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    			array('name' => 'Digits'),
    		),
    		'validators'	=> array(
    			array('name' => 'Float'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 100,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'enabled',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'discontinued',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'vatInc',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'productCategoryId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' => 0,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'productSizeId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' => 0,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'postUnitId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' => 0,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'productGroupId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' 		=> 0,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'taxCodeId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' => 0,
    			)),
    		),
    	));
    }
}
