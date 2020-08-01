<?php

declare(strict_types=1);

namespace User\Controller;

use Common\Controller\AbstractCrudController;
use User\Model\UserModel;
use User\Service\UserService as UserService;

class AdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'lastname'];
    protected $serviceName = UserService::class;
    protected $route = 'admin/user';

    public function addAction()
    {
        $this->getService()
            ->setFormOptions([
                'include_password' => true,
            ]);

        return parent::addAction();
    }

    public function resetPasswordAction()
    {
        $userId = $this->params()->fromRoute('id', null);
        $user = $this->getService()->getById($userId);

        if ($user instanceof UserModel) {
            $result = $this->getService()->resetPassword($user);

            if ($result) {
                $this->flashMessenger()->addSuccessMessage('User password has been reset and and email with new password has been sent');
            } else {
                $this->flashMessenger()->addErrorMessage('Could not reset the user password.');
            }
        } else {
            $this->flashMessenger()->addErrorMessage('Could not find the user in the database.');
        }

        return $this->redirect()->toRoute('admin/user/edit', [
            'id' => $userId
        ]);
    }

}
