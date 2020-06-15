<?php

declare(strict_types=1);

namespace User\Hydrator;

use User\Model\UserModel;
use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\EmptyString;
use Common\Hydrator\Strategy\TrueFalse;

class UserHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();

        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateModified', $dateTime);
        $this->addStrategy('active', new TrueFalse());
        return $this;
    }

    public function emptyPassword(): UserHydrator
    {
        $this->addStrategy('passwd', new EmptyString());
        return $this;
    }

    /**
     * @param UserModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'userId' => $object->getUserId(),
            'firstname' => $object->getFirstname(),
            'lastname' => $object->getLastname(),
            'email' => $object->getEmail(),
            'passwd' => $this->extractValue('passwd', $object->getPasswd()),
            'role' => $object->getRole(),
            'dateCreated' => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateModified' => $this->extractValue('dateModified', $object->getDateModified()),
            'active' => $this->extractValue('active', $object->getActive()),
        ];
    }
}
