<?php

declare(strict_types=1);

namespace SessionManager\Controller;

use Common\Controller\SettingsTrait;
use SessionManager\Form\SessionOptionsForm;
use Zend\Mvc\Controller\AbstractActionController;

class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setFormName(SessionOptionsForm::class)
            ->setConfigKey('session_manager');
    }
}
