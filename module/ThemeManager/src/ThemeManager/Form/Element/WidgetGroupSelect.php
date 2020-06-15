<?php

declare(strict_types=1);

namespace ThemeManager\Form\Element;

use Common\Service\ServiceManager;
use ThemeManager\Model\WidgetGroupModel;
use ThemeManager\Service\WidgetGroupManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class WidgetGroupSelect
 * @package ThemeManager\Form\Element
 * @method AbstractPluginManager getServiceLocator()
 */
class WidgetGroupSelect extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }

    public function getValueOptions(): array
    {
        $options = $this->valueOptions ?: $this->getOptionList();
        return $options;
    }

    public function getOptionList(): array
    {
        /** @var WidgetGroupManager $widgetGroupManager */
        $widgetGroupManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(WidgetGroupManager::class);

        $widgetGroupManager->getMapper();
        $groups = $widgetGroupManager->fetchAll();

        $groupOptions = [
            [
                'label' => 'Unassigned',
                'value' => 0,
            ]
        ];

        /* @var $group WidgetGroupModel */
        foreach($groups as $group) {
            $groupOptions[] = [
                'label' => $group->getName(),
                'value' => $group->getWidgetGroupId(),
            ];
        }

        return $groupOptions;
    }
}
