<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Common\Filter\Slug;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\I18n\View\Helper\NumberFormat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\GreaterThan;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

/**
 * Class Product
 *
 * @package Shop\InputFilter
 */
class ProductInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name'         => 'productId',
            'required'     => false,
            'filters'      => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
            'validators'   => [
            	['name' => IsInt::class],
			],
		]);
        
    	$this->add([
    		'name'       => 'ident',
    		'required'   => true,
    		'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    			['name' => Slug::class]
			],
    		'validators' => [
    			['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    	    'validators' => [
    			['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators' => [
    			['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		    ['name' => NumberFormat::class],
			],
    		'validators'	=> [
    			['name' => IsFloat::class]
			],
		]);
    	
    	$this->add([
    		'name'			=> 'description',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => NotEmpty::class],
			]
		]);
    	
    	$this->add([
    		'name'			=> 'shortDescription',
    		'required'		=> false,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => NotEmpty::class],
    			['name' => StringLength::class, 'options' => [
    				'encoding'	=> 'UTF-8',
    				'max'		=> 127
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'quantity',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => NotEmpty::class],
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options'	=> [
    				'min'		=> -1,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'addPostage',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsFloat::class],
    			['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    	    'validators'	=> [
    	        ['name' => IsInt::class],
    	        ['name' => Between::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'productSizeId',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'postUnitId',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options' => [
    				'min' => 0,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'productGroupId',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options' => [
    				'min' 		=> 0,
    				'inclusive'	=> true,
				]],
			],
		]);
    	
    	$this->add([
    		'name'			=> 'taxCodeId',
    		'required'		=> true,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
    		'validators'	=> [
    			['name' => IsInt::class],
    			['name' => GreaterThan::class, 'options' => [
    				'min' => 0,
				]],
			],
		]);
    }
}
