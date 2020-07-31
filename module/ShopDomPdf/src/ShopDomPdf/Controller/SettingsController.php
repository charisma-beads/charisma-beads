<?php

namespace ShopDomPdf\Controller;

use Common\Controller\SettingsTrait;
use ShopDomPdf\Form\DomPdfSettings;
use Laminas\Mvc\Controller\AbstractActionController;


class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(DomPdfSettings::class)
            ->setConfigKey('uthando_dompdf');
    }
}
