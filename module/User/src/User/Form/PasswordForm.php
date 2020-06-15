<?php

declare(strict_types=1);

namespace User\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Submit;

class PasswordForm extends BaseUserForm
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('firstname')
            ->remove('lastname')
            ->remove('email')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Change Password',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);
    }
}
