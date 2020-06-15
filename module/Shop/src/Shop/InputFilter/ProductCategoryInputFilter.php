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
use Common\Filter\Ucwords;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

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
