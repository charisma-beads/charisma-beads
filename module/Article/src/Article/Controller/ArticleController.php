<?php

namespace Article\Controller;

use Article\Service\ArticleService;
use Common\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;


class ArticleController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'articleId'];
    protected $serviceName = ArticleService::class;
    protected $route = 'admin/article';

    public function viewAction()
    {
        $viewModel = new ViewModel();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        $slug = $this->params()->fromRoute('slug');
        $page = $this->getService()->getArticleBySlug($slug);

        if (!$page) {
            $viewModel->setTemplate('article/article/404');
            return $viewModel;
        } else {
            $layout = ($page->getLayout()) ?: 'article/article/view';
            $viewModel->setTemplate($layout);
        }

        if (!$this->isAllowed($page->getResource(), null)) {
            throw new \Exception('Not allowed!');
        }

        $this->getService()->addPageHit($page);

        if ($this->params('model') == true) {
            $viewModel->setTemplate('article/article/model');
        }

        return $viewModel->setVariables(['page' => $page]);
    }
}
