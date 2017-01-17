<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Cart;

use Zend\Form\Form;

/**
 * Class Add
 *
 * @package Shop\Form\Cart
 */
class Add extends Form
{
	public function init()
	{
		$this->add([
			'name' => 'qty',
			'type' => 'number',
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
           'type' => 'select',
            'options' => [
                'label' => 'Product Options',
            ]
        ]);
		
		$this->add([
			'name' => 'buy-item',
			'type' => 'submit',
			'options' => [
				'label' => 'Add to Cart',
				
			],
			'attributes' => [
				'class' => 'btn',
			],
		]);
		
		$this->add([
			'name' => 'productId',
			'type' => 'hidden',
		]);
	
		$this->add([
			'name' => 'returnTo',
			'type' => 'hidden',
		]);
	}
}
