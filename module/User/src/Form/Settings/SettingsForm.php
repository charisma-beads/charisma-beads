<?php

declare(strict_types=1);

namespace User\Form\Settings;

use Laminas\Form\Form;

class SettingsForm extends Form
{
    public function init(): void
    {
        $this->add([
            'type' => UserFieldSet::class,
            'name' => 'options',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'User Options',
            ],
        ]);

        $this->add([
            'type' => LoginFieldSet::class,
            'name' => 'login_options',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'Login Options',
            ],
        ]);

        $this->add([
            'type' => AuthFieldSet::class,
            'name' => 'auth',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'Authentication Options',
            ],
        ]);
    }
}
