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
 * Class Category
 *
 * @package Shop\InputFilter\Product
 */
class Category extends InputFilter
{
    public function init()
    {
    	$this->add([
    		'name'       => 'category',
    		'required'   => true,
    		'filters'    => [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
    			['name' => 'UthandoUcwords'],
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
    		'name'			=> 'image',
    		'required'		=> false,
    		'filters'		=> [
    			['name' => 'StripTags'],
    			['name' => 'StringTrim'],
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
    		'name'			=> 'parent',
    		'required'		=> false,
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
    }
}
