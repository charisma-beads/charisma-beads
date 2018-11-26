<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Shop\Form\Element\Number;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class Add
 *
 * @package Shop\Form
 */
class CartAddFrom extends Form
{
	public function init()
	{
		$this->add([
			'name' => 'qty',
			'type' => Number::class,
			'options' => [
				'label' => 'Quantity:',
				'required' => true,
			],
			'attributes' => [
				'min'  => '0',
				'step' => '1',
				'value' => 1,		
			],
		]);

        $this->add([
           'name' => 'options',
           'type' => Select::class,
            'options' => [
                'label' => 'Product Options',
            ]
        ]);
		
		$this->add([
			'name' => 'buy-item',
			'type' => Submit::class,
			'options' => [
				'label' => 'Add to Cart',
				
			],
			'attributes' => [
				'class' => 'btn',
			],
		]);
		
		$this->add([
			'name' => 'productId',
			'type' => Hidden::class,
		]);
	
		$this->add([
			'name' => 'returnTo',
			'type' => Hidden::class,
		]);
	}
}
