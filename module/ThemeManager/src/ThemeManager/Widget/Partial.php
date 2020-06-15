<?php

declare(strict_types=1);

namespace ThemeManager\Widget;

use Common\View\AbstractViewHelper;
use ThemeManager\Model\WidgetModel;

class Partial extends AbstractViewHelper
{
    public function __invoke(WidgetModel $widgetModel): string
    {
        $params         = $widgetModel->parseParams();
        $view           = $params['view'] ?? $widgetModel->getName() ?? '';
        $widgetPartial  = 'widget/' . $this->getView()->escapeHtml($view);

        return $this->getView()->partial($widgetPartial, [
            'widget' => $widgetModel,
            'params' => $params,
        ]);
    }
}
