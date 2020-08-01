<?php

namespace Shop\Form;

use Shop\Form\Element\Number;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;

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
                'decimals' => 0,
			],
			'attributes' => [
				'min'  => '0',
				'step' => '1',
				'value' => '1',
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
