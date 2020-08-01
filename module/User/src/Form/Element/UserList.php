<?php

declare(strict_types=1);

namespace User\Form\Element;

use User\Model\UserModel;
use Common\Service\ServiceManager;
use User\Service\UserService;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

class UserList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please select a user---';

    public function getValueOptions(): array
    {
        return ($this->valueOptions) ?: $this->getUsers();
    }

    public function getUsers(): array
    {
        $users = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(UserService::class)
            ->fetchAll();

        $userOptions = [];

        /* @var $user UserModel */
        foreach ($users as $user) {
            $userOptions[] = [
                'label' => $user->getFullName(),
                'value' => $user->getUserId(),
            ];
        }

        return $userOptions;
    }
}
