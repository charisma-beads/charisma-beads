<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 18/11/14
 * Time: 14:24
 */

namespace Shop\Form\Product;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
                'label' => 'Size:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ]
        ]);
    }
} 