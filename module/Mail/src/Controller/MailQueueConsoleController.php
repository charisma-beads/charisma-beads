<?php

namespace Mail\Controller;

use Common\Service\ServiceManager;
use Mail\Service\MailQueueService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Console\Request as ConsoleRequest;


class MailQueueConsoleController extends AbstractActionController
{
    /**
     * @return string
     */
    public function sendAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $sl = $this->getServiceLocator()->get(ServiceManager::class);

        $mailQueueService = $sl->get(MailQueueService::class);

        $mailsSent = $mailQueueService->processQueue();

        return "No of mails sent: " . $mailsSent . "\r\n";
    }
}
