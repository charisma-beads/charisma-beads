<?php

declare(strict_types=1);

namespace User\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Submit;

class LoginForm extends BaseUserForm
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('firstname')
            ->remove('lastname')
            ->remove('passwd-confirm')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'rememberme',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Remember Me',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Login',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);
    }
}
