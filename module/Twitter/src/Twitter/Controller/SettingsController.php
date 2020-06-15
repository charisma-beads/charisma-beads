<?php

namespace Twitter\Controller;


use Common\Controller\SettingsTrait;
use Twitter\Form\SocialMediaForm;
use Zend\Mvc\Controller\AbstractActionController;

class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(SocialMediaForm::class)
            ->setConfigKey('uthando_social_media');
    }
}