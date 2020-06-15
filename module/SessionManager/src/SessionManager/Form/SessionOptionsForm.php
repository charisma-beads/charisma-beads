<?php

declare(strict_types=1);

namespace SessionManager\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class SessionOptionsForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => SessionConfigOptionsFieldSet::class,
            'name' => 'config_options',
            'options' => [
                'label' => 'Session Config Options',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => SessionOptionsFieldSet::class,
            'name' => 'options',
            'options' => [
                'label' => 'Session Options',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}