<?php

namespace Newsletter\Controller;

use Common\Controller\AbstractCrudController;
use Common\UthandoException;
use Newsletter\Service\MessageService;
use Newsletter\View\Model\NewsletterViewModel;

/**
 * Class Message
 *
 * @package Newsletter\Controller
 * @method MessageService getService($service = null, $options = [])
 */
class MessageController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'messageId'];
    protected $serviceName = MessageService::class;
    protected $route = 'admin/newsletter/message';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterViewModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('message/' . $id);

        return $viewModel;
    }

    public function sendAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        try {
            $result = $this->getService()->sendMessage($id);
            $this->flashMessenger()->addSuccessMessage(
                $result . ' Messages added to Mail Queue.'
            );
        } catch (UthandoException $e) {
            $this->setExceptionMessages($e);
        }
        
        return $this->redirect()->toRoute($this->getRoute());
    }
}