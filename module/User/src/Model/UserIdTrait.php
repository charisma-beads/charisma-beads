<?php

declare(strict_types=1);

namespace User\Model;

use Common\Model\ModelInterface;

trait UserIdTrait
{
    /**
     * @var int
     */
    protected $userId;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): ModelInterface
    {
        $this->userId = $userId;
        return $this;
    }
}
