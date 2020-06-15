<?php

namespace Events\Controller;

use Common\Controller\SettingsTrait;
use Events\Form\SettingsForm;
use Zend\Mvc\Controller\AbstractActionController;


class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(SettingsForm::class)
            ->setConfigKey('uthando_events');
    }
}
