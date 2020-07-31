<?php

namespace Contact\Controller;

use Common\Controller\SettingsTrait;
use Contact\Form\ContactSettings;
use Laminas\Mvc\Controller\AbstractActionController;


class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setFormName(ContactSettings::class)
            ->setConfigKey('uthando_contact');
    }
}
