<?php

declare(strict_types=1);

namespace User\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Submit;

class ForgotPasswordForm extends BaseUserForm
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('firstname')
            ->remove('lastname')
            ->remove('show-password')
            ->remove('passwd')
            ->remove('passwd-confirm')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->addCaptcha();

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Reset Password',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);

    }
}
