<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Fieldset;

class OauthOptionsFieldSet extends Fieldset
{
    public function init()
    {
        $this->add([
            'type' => TwitterAccessTokenFieldSet::class,
            'name' => 'access_token',
            'options' => [
                //'label' => 'Twitter Settings',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);

        $this->add([
            'type' => TwitterOauthOptionsFieldSet::class,
            'name' => 'oauth_options',
            'options' => [
                //'label' => 'Twitter Settings',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);
    }
}