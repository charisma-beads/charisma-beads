<?php

declare(strict_types=1);

namespace User\Controller;

use Common\Controller\SettingsTrait;
use User\Form\Settings\SettingsForm as SettingsForm;
use Laminas\Mvc\Controller\AbstractActionController;

class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(SettingsForm::class)
            ->setConfigKey('user');
    }
}