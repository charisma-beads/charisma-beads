<?php

namespace Testimonial\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;


class TestimonialForm extends Form
{
    public function init()
    {
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
            ],
            'attributes' => [
                'placeholder' => 'Name',
            ],
        ]);

        $this->add([
            'name' => 'image',
            'type' => Text::class,
            'options' => [
                'label' => 'Image',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('testimonial-image-button', [
                    'label' => 'Add Image',
                ]),
            ],
            'attributes' => [
                'placeholder' => 'Image',
                'id' => 'testimonial-image',
            ],
        ]);

        $this->add([
            'name' => 'location',
            'type' => Text::class,
            'options' => [
                'label' => 'Location',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Location',
            ],
        ]);

        $this->add([
            'name' => 'company',
            'type' => Text::class,
            'options' => [
                'label' => 'Company',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Company',
            ],
        ]);

        $this->add([
            'name' => 'website',
            'type' => Text::class,
            'options' => [
                'label' => 'Website',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Website',
            ],
        ]);

        $this->add([
            'name' => 'sector',
            'type' => Text::class,
            'options' => [
                'label' => 'Sector',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Sector',
            ],
        ]);

        $this->add([
            'name' => 'text',
            'type' => Textarea::class,
            'options' => [
                'label' => 'HTML',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'HTML Content',
                'class'       => 'editable-textarea',
                'id'          => 'testimonial-content-textarea',
                'rows'        => 25,
            ]
        ]);

        $this->add([
            'name' => 'testimonialId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'security',
            'type' => 'csrf',
        ]);
    }
}

;