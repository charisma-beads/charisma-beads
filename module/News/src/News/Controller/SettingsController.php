<?php

namespace News\Controller;

use Common\Controller\SettingsTrait;
use News\Form\NewsSettingsForm;
use Zend\Mvc\Controller\AbstractActionController;


class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setFormName(NewsSettingsForm::class)
            ->setConfigKey('uthando_news');
    }
}
