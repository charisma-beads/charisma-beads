<?php

declare(strict_types=1);

namespace User\Controller;

use User\Service\UserRegistrationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Common\Service\ServiceTrait;

class RegistrationController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = UserRegistrationService::class;
    }

    public function verifyEmailAction()
    {
        if (!$this->getRequest()->isGet()) {
            return $this->redirect()->toRoute('home');
        }

        $token = $this->params('token', null);
        $email = $this->params('email', null);

        $result = false;

        if ($token && $email) {
            $result = $this->getService()->verify($token, $email);
        }

        return [
            'result' => $result,
        ];
    }
}
