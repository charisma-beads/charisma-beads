<?php

namespace Newsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Form\Element\Captcha;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;


class PreferencesForm extends SubscriberForm
{
    public function init()
    {
        parent::init();

        $this->remove('subscriberId')
            ->remove('dateCreated')
            ->remove('name')
            ->remove('subscribe');

        $this->add([
            'name' => 'captcha',
            'type' => Captcha::class,
            'attributes' => [
                'placeholder' => 'Type letters and number here',
            ],
            'options' => [
                'label' => 'Please verify you are human.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
                'label_attributes' => [
                    'class' => 'col-sm-10 col-sm-offset-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Remove Email',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);

    }
}
