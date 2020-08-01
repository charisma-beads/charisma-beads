<?php

declare(strict_types=1);

namespace Admin\View;

use Common\View\AbstractViewHelper;

class TextEditor extends AbstractViewHelper
{
    public function summernote(): void
    {
        $view = $this->getView();

        $view->headLink()->appendStylesheet($view->basePath('css/summernote.css'));
        $view->inlineScript()->appendFile($view->basePath('js/summernote.js'));

        $view->placeholder('js-scripts')->append(
            $view->partial(
                'admin/partial/summernote'
            )
        );
    }

    public function codeMirror(): void
    {
        $view = $this->getView();
        $view->headLink()->appendStylesheet($view->basePath('css/codemirror.css'));
        $view->inlineScript()->appendFile($view->basePath('js/codemirror.js'));

        $view->placeholder('js-scripts')->append(
            $view->partial(
                'admin/partial/code-mirror'
            )
        );
    }
}
