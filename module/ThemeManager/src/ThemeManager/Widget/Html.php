<?php

namespace ThemeManager\Widget;

use Common\View\AbstractViewHelper;
use ThemeManager\Model\WidgetModel;

class Html extends AbstractViewHelper
{
    public function __invoke(WidgetModel $widgetModel): string
    {
        $view   = $this->getView();
        $params = $widgetModel->parseParams();
        $class  = $params['class'] ?? '';
        $html   = ($class) ? '<div class="' . $view->escapeHtml($class) . '">' : '';
        $html  .= $widgetModel->getHtml();
        $html  .=  ($class) ? '</div>' : '';

        return $html;
    }
}
