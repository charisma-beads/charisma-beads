<?php


namespace User\Controller;


use Common\Service\ServiceManager;
use User\Service\UserRegistrationService;
use User\Service\UserService;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class UserConsoleController extends AbstractActionController
{
    public function cleanupAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $sl = $this->getServiceLocator()->get(ServiceManager::class);

        /** @var UserService $userService */
        $userService    = $sl->get(UserService::class);
        $deletedUsers   = $userService->cleanupUsers();

        /** @var UserRegistrationService $registrationService */
        $registrationService = $sl->get(UserRegistrationService::class);
        $deletedRegistrations = $registrationService->cleanupRegistrations();

        return sprintf("No of users deleted: %s \r\nNo of registrations deleted: %s \r\n", $deletedUsers, $deletedRegistrations) ;
    }
}
