<?php

declare(strict_types=1);

namespace User\Form;

class UserForm extends BaseUserForm
{
    public function init(): void
    {
        parent::init();

        if (!$this->getOption('include_password')) {
            $this->remove('passwd')
                ->remove('passwd-confirm')
                ->remove('show-password');
        }


    }
}
