<?php

namespace FileManager\Controller;

use Common\Controller\SettingsTrait;
use FileManager\Form\FileManagerSettingsForm;
use Zend\Mvc\Controller\AbstractActionController;


class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(FileManagerSettingsForm::class)
            ->setConfigKey('uthando_file_manager');
    }
}
