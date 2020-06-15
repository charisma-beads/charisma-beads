<?php

declare(strict_types=1);

namespace User\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use User\InputFilter\UserInputFilter as UserInputFilter;
use Zend\Form\Element\Submit;
use Zend\InputFilter\InputFilterInterface;

class RegisterForm extends BaseUserForm
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Register',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ], ['priority' => -1000]);
    }
}
