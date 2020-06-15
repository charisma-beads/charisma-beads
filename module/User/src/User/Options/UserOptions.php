<?php

declare(strict_types=1);

namespace User\Options;

use Zend\Stdlib\AbstractOptions;

class UserOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $disableUserLogin = true;

    /**
     * @var bool
     */
    protected $disableUserRegister = true;

    public function getDisableUserLogin(): bool
    {
        return $this->disableUserLogin;
    }

    public function setDisableUserLogin(bool $disableUserLogin): UserOptions
    {
        $this->disableUserLogin = $disableUserLogin;
        return $this;
    }

    public function getDisableUserRegister(): bool
    {
        return $this->disableUserRegister;
    }

    public function setDisableUserRegister(bool $disableUserRegister): UserOptions
    {
        $this->disableUserRegister = $disableUserRegister;
        return $this;
    }
}
