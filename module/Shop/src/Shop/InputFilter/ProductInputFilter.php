<?php

namespace Shop\InputFilter;

use Common\Filter\Slug;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\I18n\View\Helper\NumberFormat;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

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
