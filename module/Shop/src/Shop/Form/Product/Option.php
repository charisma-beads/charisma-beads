<?php

namespace Shop\Form\Product;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class Option extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productOptionId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'productId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'		=> 'postUnitId',
            'type'		=> 'PostUnitList',
            'options'	=> [
                'label'			=> 'Weight:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'option',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Option:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Option:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'price',
            'type'			=> 'number',
            'attributes'	=> [
                'placeholder'	=> 'Price:',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ],
            'options'		=> [
                'label'			=> 'Price:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'discountPercent',
            'type'			=> 'number',
            'attributes'	=> [
                'autofocus'	=> true,
                'min'		=> '0.00',
                'max'		=> '100.00',
                'step'		=> '0.01',
                'value'     => '0',
            ],
            'options'		=> [
                'label'			=> 'Product Discount:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ]
        ]);
    }
} 