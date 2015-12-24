<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

/**
 * Class Product
 *
 * @package Shop\InputFilter\Product
 */
class Product extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name'         => 'productId',
            'required'     => false,
            'filters'      => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
			],
            'validators'   => [
            	['name' => 'Int'],
			],
		]);
        
    	$this->add([
    		'name'       => 'ident',
    		'required'   => true,
    		'filters'    => [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
    			['name' => 'UthandoSlug']
			],
    		'validators' => [
    			['name' => 'StringLength', 'options' => [
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
				]],
			],
		]);
    	
    	$this->add([
    	    'name'         => 'sku',
    	    'required'     => false,
    	    'filters'      => [
    	        ['name' => 'StripTags'],
    	        ['name' => 'StringTrim'],
    	        ['name' => 'StringToUpper'],
			],
    	    'validators' => [
    			['name' => 'StringLength', 'options' => [
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 50,
				]],
			],
		]);
    	
    	$this->add([
    		'name'       => 'name',
    		'required'   => true,
    		'filters'    => [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators' => [
    			['name' => 'StringLength', 'options' => [
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 127,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'price',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
    		    ['name' => 'NumberFormat'],
			],
    		'validators'	=> [
    			['name' => 'Float']
			],
		]);
    	
    	$this->add([
    		'name'			=> 'description',
    		'required'		=> true,
    		'filters'		=> [
    			['name'	=> 'StringTrim']
			],
    		'validators'	=> [
    			['name' => 'NotEmpty'],
			]
		]);
    	
    	$this->add([
    		'name'			=> 'shortDescription',
    		'required'		=> false,
    		'filters'		=> [
    			['name'	=> 'StripTags'],
    			['name'	=> 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'NotEmpty'],
    			['name' => 'StringLength', 'options' => [
    				'encoding'	=> 'UTF-8',
    				'max'		=> 127
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'quantity',
    		'required'		=> true,
    		'filters'		=> [
    			['name'	=> 'StripTags'],
    			['name'	=> 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'NotEmpty'],
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options'	=> [
    				'min'		=> -1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'addPostage',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'Between', 'options' => [
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'discountPercent',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Float'],
    			['name' => 'Between', 'options' => [
    				'min'		=> 0,
    				'max'		=> 100,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'enabled',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'Between', 'options' => [
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'discontinued',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'Between', 'options' => [
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'vatInc',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'Between', 'options' => [
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    	    'name'			=> 'showImage',
    	    'required'		=> true,
    	    'filters'		=> [
    	        ['name' => 'StripTags'],
    	        ['name' => 'StringTrim'],
			],
    	    'validators'	=> [
    	        ['name' => 'Int'],
    	        ['name' => 'Between', 'options' => [
    	            'min'		=> 0,
    	            'max'		=> 1,
    	            'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'productCategoryId',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'productSizeId',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'postUnitId',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'productGroupId',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options' => [
    				'min' 		=> 0,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'taxCodeId',
    		'required'		=> true,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
			],
    		'validators'	=> [
    			['name' => 'Int'],
    			['name' => 'GreaterThan', 'options' => [
    				'min' => 0,
				]],
			],
		]);
    }
}
