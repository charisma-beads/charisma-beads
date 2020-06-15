<?php

declare(strict_types=1);

namespace ThemeManager\Controller;

use AssetManager\Service\AssetManager;
use Common\Controller\SettingsTrait;
use ThemeManager\Form\ThemeManagerSettingsForm;
use Zend\Mvc\Controller\AbstractActionController;

class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(ThemeManagerSettingsForm::class)
            ->setConfigKey('uthando_theme_manager');
    }

    public function resetCacheAction()
    {
        $collection = $this->getServiceLocator()
            ->get(AssetManager::class)
            ->getResolver()
            ->collect();

        $dirs = [];

        foreach ($collection as $file) {

            $info = pathinfo('./public/'.$file);

            $dirname = explode('/', $info['dirname']);

            if (isset($dirname[2])) {
                $dirname = join('/', [
                    $dirname[0],
                    $dirname[1],
                    $dirname[2],
                ]);

                if (!in_array($dirname, $dirs)) {
                    $dirs[] = $dirname;
                }
            }
        }

        foreach ($dirs as $dir) {
            $this->recursiveRemove($dir);
        }

        $this->flashMessenger()->addInfoMessage('Asset cache has been reset.');

        return $this->redirect()->toRoute('admin/theme-manager/settings');
    }

    protected function recursiveRemove($node)
    {
        if (is_dir($node)) {
            $objects = scandir($node);

            foreach ($objects as $object) {
                if ($object === '.' || $object === '..') {
                    continue;
                }
                $this->recursiveRemove($node . '/' . $object);
            }
            rmdir($node);
        } elseif (is_file($node)) {
            unlink($node);
        }
    }
}
