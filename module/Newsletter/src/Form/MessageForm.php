<?php

namespace Newsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Newsletter\Form\Element\NewsletterList;
use Newsletter\Form\Element\TemplateList;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;


class MessageForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'messageId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'newsletterId',
            'type' => NewsletterList::class,
            'options' => [
                'label' => 'Newsletter',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'templateId',
            'type' => TemplateList::class,
            'options' => [
                'label' => 'Template',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'subject',
            'type' => Text::class,
            'options' => [
                'label' => 'Subject',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'params',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Params',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'message',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Body',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'class' => 'editable-textarea',
                'rows' => 25,
            ],
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}