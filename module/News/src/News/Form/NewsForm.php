<?php

declare(strict_types=1);

namespace News\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;


class NewsForm extends Form
{
    public function init(): void
    {
        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label'     => 'Title',
                'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Article Title',
            ],
        ]);

        $this->add([
            'name' => 'slug',
            'type' => Text::class,
            'options' => [
                'label'       => 'Slug',
                'required'    => false,
                'help-block' => 'If you leave this blank the the title will be used for the slug.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Slug',
            ],
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
            ],
            'attributes' => [
                'placeholder' => 'Description',
            ],
        ]);

        $this->add([
            'name' => 'image',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Image',
                'id' => 'news-image',
            ],
            'options' => [
                'label' => 'Image',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('news-image-button', [
                    'label' => 'Add Image',
                ]),
            ],
        ]);

        $this->add([
            'name' => 'layout',
            'type' => Text::class,
            'options' => [
                'label' => 'Layout',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Layout',
            ],
        ]);

        $this->add([
            'name' => 'lead',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Lead Text',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Lead Text',
                'id'          => 'news-lead-textarea',
                'rows'        => 10,
            ],
        ]);

        $this->add([
            'name' => 'content',
            'type' => Textarea::class,
            'options' => [
                'label' => 'HTML Content',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'HTML Content',
                'class'       => 'editable-textarea',
                'id'          => 'news-content-textarea',
                'rows'        => 25,
            ],
        ]);

        $this->add([
            'name' => 'dateCreated',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date Created',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:i:s'
            ],
            'attributes' => [
                'disabled' => true,
            ]
        ]);

        $this->add([
            'name' => 'dateModified',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date Modified',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:m:s'
            ],
            'attributes' => [
                'disabled' => true,
            ],
        ]);

        $this->add([
            'name' => 'newsId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'userId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
} 