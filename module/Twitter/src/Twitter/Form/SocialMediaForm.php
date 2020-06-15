<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class SocialMediaForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => TwitterFieldSet::class,
            'name' => 'twitter',
            'options' => [
                'label' => 'Twitter Settings',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}