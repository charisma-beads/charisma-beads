<?php

declare(strict_types=1);

namespace SessionManager\Controller;

use Common\Service\ServiceManager;
use SessionManager\Service\SessionManagerService;
use Laminas\Console\Request;
use Laminas\Mvc\Controller\AbstractActionController;

class SessionManagerConsole extends AbstractActionController
{
    public function gcAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $sl = $this->getServiceLocator()->get(ServiceManager::class);

        $sessionManagerService = $sl->get(SessionManagerService::class);

        $result = $sessionManagerService->gc();

        return "No of rows deleted: " . $result . "\r\n";
    }
}
