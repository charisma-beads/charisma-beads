<?php

namespace Contact\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Form\Element\Captcha;
use Contact\Model\AbstractLine;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;


class ContactForm extends Form
{
    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = $options['name'];
            unset($options['name']);
        }

        parent::__construct($name, $options);
    }

    /**
     * Set up form elements
     */
    public function init()
    {
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Full Name',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'attributes' => [
                'placeholder' => 'Email Address',
            ],
            'options' => [
                'label' => 'Email',
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
            'attributes' => [
                'placeholder' => 'Subject',
            ],
        ]);

        $this->add([
            'name' => 'transport',
            'type' => Select::class,
            'options' => [
                'label' => 'Department',
                'value_options' => $this->getTransportList(),
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'body',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Message',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Your message',
                'rows' => 10,
            ],
        ]);

        if (true === $this->getOption('enable_captcha')) {
            $this->add([
                'name' => 'captcha',
                'type' => Captcha::class,
                'attributes' => [
                    'placeholder' => 'Type letters and number here',
                ],
                'options' => [
                    'label' => 'Please verify you are human',
                    'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                    'column-size' => 'sm-10 col-sm-offset-2',
                    'label_attributes' => [
                        'class' => 'col-sm-10 col-sm-offset-2',
                    ],
                ],
            ]);
        }

        $this->add([
            'name' => 'csrf',
            'type' => Csrf::class,
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'id' => 'contact-submit-button',
                'class' => 'btn btn-primary',
            ],
            'options' => [
                'label' => 'Send',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);
    }

    /**
     * @return array
     */
    public function getTransportList(): array
    {
        $list           = $this->getOption('transport_list');
        $listOptions    = [];

        /*  @var AbstractLine $transport */
        foreach($list as $transport) {
            $listOptions[$transport->getLabel()] = $transport->getText();
        }

        return $listOptions;
    }
}
