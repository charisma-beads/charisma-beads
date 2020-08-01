<?php

declare(strict_types=1);

namespace ThemeManager\Widget;

use Common\View\AbstractViewHelper;
use ThemeManager\Model\WidgetModel;
use ThemeManager\View\WidgetGroupServiceTrait;

class LayoutRow extends AbstractViewHelper
{
    use WidgetGroupServiceTrait;

    public function __invoke(WidgetModel $widgetModel): string
    {
        $widgetGroup    = $this->getWidgetGroupService()->getWidgetGroupByName($widgetModel->getName());
        $view           = $this->getView();
        $params         = $widgetModel->parseParams();
        $class          = $params['class'] ?? '';
        $html           = ($class) ? '<div class="' . $view->escapeHtml($class) . '">' : '';

        /** @var WidgetModel $widgetModel */
        foreach ($widgetGroup->getWidgets() as $widgetModel) {
            $widgetClass = $view->escapeHtml($widgetModel->getWidget());

            if ($this->getServiceLocator()->has($widgetClass)) {
                $html .= $view->{$widgetClass}($widgetModel);
            }
        }

        $html .= ($class) ? '</div>' : '';

        return $html;
    }
}
