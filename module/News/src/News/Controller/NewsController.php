<?php

namespace News\Controller;

use Common\Service\ServiceTrait;
use News\Options\NewsOptions;
use News\Service\NewsService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class NewsForm
 *
 * @package News\Controller
 * @method \News\Service\NewsService getService()
 */
class NewsController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName(NewsService::class);
    }

    public function viewAction()
    {
        /* @var \News\Options\NewsOptions $options */
        $options = $this->getService(NewsOptions::class);
        $search = $this->params()->fromPost('search', null);

        $params = [
            'sort'  => $options->getSortOrder(),
            'count' => $options->getItemsPerPage(),
            'page'  => $this->params()->fromRoute('page'),
            'title-description' => $search,
            //'tag'   => $this->params()->fromRoute('tag'),
        ];

        $service = $this->getService();

        $service->usePaginator([
            'limit' => $params['count'],
            'page' => $params['page'],
        ]);

        $viewModel = new ViewModel([
            'models'    => $service->search($params),
            'view'      => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
        ]);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        return $viewModel;
    }

    public function newsItemAction()
    {
        $slug = $this->params()->fromRoute('news-item', null);

        if (null === $slug) {
            return $this->redirect()->toRoute('news-list');
        }

        $viewModel  = new ViewModel();
        $model      = $this->getService()->getBySlug($slug);

        if (!$model) {
            $viewModel->setTemplate('news/news/404');
            return $viewModel;
        } else {
            $layout = ($model->getLayout()) ?: 'news/news/news-item';
            $viewModel->setTemplate($layout);
        }

        $this->getService()->addPageHit($model);

        return $viewModel->setVariables(['model' => $model]);

    }
} 