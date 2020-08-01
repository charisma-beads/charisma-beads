<?php

namespace Navigation\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;


class MenuForm extends Form
{
	public function init()
    {
        $this->add([
            'name' => 'menu',
            'type' => Text::class,
            'options' => [
                'label' => 'Menu Title',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Menu Title',
            ],
        ]);

        $this->add([
            'name' => 'menuId',
            'type' => Hidden::class,
        ]);


        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}
