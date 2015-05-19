<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class PostUnit extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'postUnit');
	protected $serviceName = 'ShopPostUnit';
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
