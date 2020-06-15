<?php

declare(strict_types=1);

namespace FileManager\View;

use Common\View\AbstractViewHelper;

class FileManager extends AbstractViewHelper
{
    public function standalone(): void
    {
        $this->addDependencies();

        $this->getView()->placeholder('js-scripts')->append(
            $this->getView()->partial(
                'file-manager/file-manager/standalone'
            )
        );
    }

    public function summernote(): void
    {
        $view = $this->getView();

        $this->addDependencies();

        $view->placeholder('js-scripts')->append(
            $view->partial(
                'file-manager/file-manager/elfinder-dialog'
            )
        );
    }

    public function uploadButton(string $elementId, string $elementName): void
    {
        $this->elfinderUpload($elementId, $elementName);
    }

    public function elfinderUpload(string $elementId, string $elementName): void
    {
        $this->addDependencies();

        $this->getView()->placeholder('js-scripts')->append(
            $this->getView()->partial(
                'file-manager/file-manager/upload-button', [
                'elementId' => $elementId,
                'elementName' => $elementName,
            ])
        );
    }

    public function legacyUpload(string $elementId, string $elementName): void
    {
        $this->getView()->placeholder('js-scripts')->append(
            $this->getView()->partial(
                'file-manager/uploader/upload-button', [
                'elementId' => $elementId,
                'elementName' => $elementName,
            ])
        );
    }

    public function addDependencies(): void
    {
        $view = $this->getView();
        $view->inlineScript()->appendFile($view->basePath('el-finder/js/elfinder.full.js'));
        //$view->headLink()->appendStylesheet($view->basePath('el-finder/css/elfinder.full.css'));
    }
}
