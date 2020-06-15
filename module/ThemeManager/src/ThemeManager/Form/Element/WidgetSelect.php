<?php

declare(strict_types=1);

namespace ThemeManager\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class WidgetSelect
 * @package ThemeManager\Form\Element
 * @method AbstractPluginManager getServiceLocator()
 */
class WidgetSelect  extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Select Widget---';

    public function getValueOptions(): array
    {
        $options = $this->valueOptions ?: $this->getOptionList();
        return $options;
    }

    public function getOptionList(): array
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');

        $widgets = preg_grep(
            '/\\\\Widget\\\\/',
            $config['view_helpers']['invokables']
        );

        $widgetOptions= [];

        foreach($widgets as $widget) {
            $widgetOptions[] = [
                'label' => $widget,
                'value' => $widget,
            ];
        }

        return $widgetOptions;
    }
}
