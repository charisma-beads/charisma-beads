<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 18/11/14
 * Time: 14:24
 */

namespace Shop\Form\Product;

use Zend\Form\Form;

class Size extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'size',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Size:'
            ],
            'options' => [
                'label' => 'Size:'
            ]
        ]);
    }
} 