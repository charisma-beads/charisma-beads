<?php

namespace Newsletter\Controller;

use Common\Controller\AbstractCrudController;
use Newsletter\Service\TemplateService;
use Newsletter\View\Model\NewsletterViewModel;


class TemplateController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'templateId'];
    protected $serviceName = TemplateService::class;
    protected $route = 'admin/newsletter/template';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterViewModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('template/' . $id);

        return $viewModel;
    }
}