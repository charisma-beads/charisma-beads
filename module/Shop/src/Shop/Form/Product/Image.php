<?php
namespace Shop\Form\Product;

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
                'label' => 'Thumbnail:'
            ],
        ]);

        $this->add([
            'name' => 'full',
            'type' => 'text',
            'options' => [
                'label' => 'Full Image:'
            ]
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
            ],
        ]);
    }
}
