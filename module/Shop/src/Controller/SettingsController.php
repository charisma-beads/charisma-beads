<?php

namespace Shop\Controller;

use Common\Controller\SettingsTrait;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * Class Settings
 *
 * @package Shop\Controller
 */
class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(\Shop\Form\Settings\SettingsForm::class)
            ->setConfigKey('shop');
    }
}
