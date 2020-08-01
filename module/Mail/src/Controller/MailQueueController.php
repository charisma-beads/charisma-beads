<?php

namespace Mail\Controller;

use Common\Controller\AbstractCrudController;
use Mail\Service\MailQueueService;
use Laminas\Http\PhpEnvironment\Response;


class MailQueueController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'mailQueueId'];
    protected $serviceName = MailQueueService::class;
    protected $route = 'admin/mail-queue';

    /**
     * @return \Laminas\Http\Response
     */
    public function addAction()
    {
        return $this->redirect()->toRoute($this->route);
    }

    /**
     * @return \Laminas\Http\Response
     */
    public function editAction()
    {
        return $this->redirect()->toRoute($this->route);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $del     = $request->getPost('submit', 'No');
        $ids     = $request->getPost('ids', []);

        if ($request->isPost() && $del == 'delete') {

            $result = $this->getService()->delete($ids);

            $this->flashMessenger()->addSuccessMessage(sprintf('%s rows were deleted form database.', $result));

        }

        return $this->redirect()->toRoute($this->getRoute('delete'), $this->params()->fromRoute());
    }
}
