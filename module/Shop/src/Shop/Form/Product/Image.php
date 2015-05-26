<?php
namespace Shop\Form\Product;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class Image extends Form
{
    public function init()
    {
        $this->add([
        	'name'	=> 'productImageId',
        	'type'	=> 'hidden',
        ]);

        $this->add([
            'name'	=> 'productId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name' => 'thumbnail',
            'type' => 'text',
            'options' => [
                'label' => 'Thumbnail:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'full',
            'type' => 'text',
            'options' => [
                'label' => 'Full Image:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'isDefault',
            'type' => 'select',
            'options' => [
                'label' => 'Is Default:',
                'value_options' => [
                    '0'	=> 'No',
                    '1'	=> 'Yes',
                ],
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
}
