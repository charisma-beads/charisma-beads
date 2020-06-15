<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Common\Controller\SettingsTrait;
use Zend\Mvc\Controller\AbstractActionController;

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
