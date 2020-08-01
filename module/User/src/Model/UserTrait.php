<?php

declare(strict_types=1);

namespace User\Model;

use Common\Model\ModelInterface;

trait UserTrait
{
    use UserIdTrait;

    /**
     * @var UserModel
     */
    protected $user;

    public function getUser(): UserModel
    {
        return $this->user;
    }

    public function setUser(UserModel $user): ModelInterface
    {
        $this->user = $user;
        return $this;
    }
}
