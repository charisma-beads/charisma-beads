<?php

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Image
 *
 * @package Shop\Form
 */
class ProductImageForm extends Form
{
    public function init()
    {
        $this->add([
        	'name'	=> 'productImageId',
        	'type'	=> Hidden::class,
        ]);

        $this->add([
            'name'	=> 'productId',
            'type'	=> Hidden::class,
        ]);

        $this->add([
            'name' => 'thumbnail',
            'type' => Text::class,
            'options' => [
                'label' => 'Thumbnail:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'full',
            'type' => Text::class,
            'options' => [
                'label' => 'Full Image:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'isDefault',
            'type' => Select::class,
            'options' => [
                'label' => 'Is Default:',
                'value_options' => [
                    '0'	=> 'No',
                    '1'	=> 'Yes',
                ],
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
    }
}
