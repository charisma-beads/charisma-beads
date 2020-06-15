<?php

namespace ThemeManager\Widget;

use Common\View\AbstractViewHelper;
use ThemeManager\Model\WidgetModel;

class Content extends AbstractViewHelper
{
    public function __invoke(WidgetModel $widgetModel) : string
    {
        $view = $this->getView();
        $params = $widgetModel->parseParams();
        $class = (isset($params['class'])) ? $params['class'] : '';

        $html = ($class) ? '<div class="' . $view->escapeHtml($class) . '">' : '';
        $html .= $view->get('content');
        $html .= ($class) ? '</div>' : '';

        return $html;
    }
}
