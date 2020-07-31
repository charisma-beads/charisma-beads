<?php

namespace Common\Mvc\Controller;

use Common\Controller\SettingsTrait;
use Common\Form\Settings\CommonSettings;
use Laminas\Mvc\Controller\AbstractActionController;


class Settings extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(CommonSettings::class)
            ->setConfigKey('common');
    }
}
