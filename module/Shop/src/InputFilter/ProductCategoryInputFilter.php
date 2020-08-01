<?php

namespace Shop\InputFilter;

use Common\Filter\Slug;
use Common\Filter\Ucwords;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

/**
 * Class Category
 *
 * @package Shop\InputFilter
 */
class ProductCategoryInputFilter extends InputFilter
{
    public function init()
    {
    	$this->add([
    		'name'       => 'category',
    		'required'   => true,
    		'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    			['name' => Ucwords::class],
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
    		'name'			=> 'image',
    		'required'		=> false,
    		'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
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
    		'name'			=> 'parent',
    		'required'		=> false,
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
    }
}
