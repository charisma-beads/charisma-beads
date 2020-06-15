<?php

namespace Newsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class NewsletterForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'newsletterId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
        ]);

        $this->add([
            'name' => 'description',
            'type' => Text::class,
            'options' => [
                'label' => 'Description',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
        ]);

        $this->add([
            'name' => 'visible',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Visible',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}