<?php

declare(strict_types=1);

namespace User\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime;
use Common\Hydrator\Strategy\TrueFalse;

class UserRegistrationHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('requestTime', new DateTime());
        $this->addStrategy('responded', new TrueFalse());

        return $this;
    }

    /**
     * @param \User\Model\UserRegistrationModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'userRegistrationId' => $object->getUserRegistrationId(),
            'userId' => $object->getUserId(),
            'token' => $object->getToken(),
            'requestTime' => $this->extractValue('requestTime', $object->getRequestTime()),
            'responded' => $this->extractValue('responded', $object->getResponded()),
        ];
    }
}
