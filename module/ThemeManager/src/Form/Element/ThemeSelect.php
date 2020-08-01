<?php

declare(strict_types=1);

namespace ThemeManager\Form\Element;

use ThemeManager\Options\ThemeOptions;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ThemeSelect
 * @package ThemeManager\Form\Element
 * @method AbstractPluginManager getServiceLocator()
 */
class ThemeSelect extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = 'Default';

    public function init()
    {
        /** @var ThemeOptions $themeOptions */
        $themeOptions   = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ThemeOptions::class);
        $themePath      = $themeOptions->getThemePath();
        $themes         = scandir($themePath);
        $optionsList    = [];

        foreach ($themes as $theme) {

            if ($theme == '.' || $theme == '..') continue;

            $optionsList[] = [
                'label' => mb_convert_case(str_replace('-', ' ', $theme), MB_CASE_TITLE),
                'value' => $theme,
            ];
        }

        $this->setValueOptions($optionsList);
    }
}
