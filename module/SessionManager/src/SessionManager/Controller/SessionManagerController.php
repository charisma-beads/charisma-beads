<?php

namespace SessionManager\Controller;

use Common\Controller\AbstractCrudController;
use SessionManager\Service\SessionManagerService;
use Zend\View\Model\ViewModel;

class SessionManagerController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'id'];
    protected $serviceName = SessionManagerService::class;
    protected $route = 'admin/session';

    public function indexAction()
    {
        try {
            $viewModel = parent::indexAction();
        } catch (\Exception $e) {
            $model = new ViewModel();
            $model->setTemplate('session-manager/session-manager/not-implemented');
        }

        return $viewModel;
    }

    public function viewAction()
    {
        $id = (string)$this->params()->fromRoute('id', 0);

        $viewModel = new ViewModel(array(
            'session' => $this->getService()->getById($id)
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function addAction()
    {
        return $this->redirect()->toRoute($this->getRoute());
    }

    public function editAction()
    {
        return $this->redirect()->toRoute($this->getRoute());
    }
}