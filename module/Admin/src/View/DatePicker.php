<?php declare(strict_types=1);

namespace Admin\View;

use Common\View\AbstractViewHelper;

class DatePicker extends AbstractViewHelper
{
    public function __invoke($date)
    {
        $view = $this->getView();

        $view->headLink()->appendStylesheet($view->basePath('css/bootstrap-datetimepicker.css'));
        $view->inlineScript()->appendFile($view->basePath('js/bootstrap-datetimepicker.js'));
        $view->placeholder('js-scripts')->append(
            $view->partial(
                'admin/partial/date-picker', [
                    'date' => $date,
                ])
        );
    }
}
