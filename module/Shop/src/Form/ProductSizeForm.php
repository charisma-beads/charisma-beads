<?php

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Size
 *
 * @package Shop\Form
 */
class ProductSizeForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'size',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Size'
            ],
            'options' => [
                'label' => 'Size',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
        ]);
    }
} 