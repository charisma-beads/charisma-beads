<?php

namespace Shop\Controller;

use Shop\Service\PostUnitService;
use Common\Controller\AbstractCrudController;
use Laminas\View\Model\ViewModel;

/**
 * Class PostUnit
 *
 * @package Shop\Controller
 */
class PostUnitController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'postUnit');
	protected $serviceName = PostUnitService::class;
	protected $route = 'admin/shop/post/unit';

    public function postListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $models = $this->getService()->fetchAll();

        $viewModel = new ViewModel([
            'models' => $models,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
}
