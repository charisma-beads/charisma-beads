<?php

declare(strict_types=1);

namespace User\Crypt\Password;

use Laminas\Crypt\Password\PasswordInterface;

class Md5 implements PasswordInterface
{
    public function verify($password, $hash): bool
    {
        $result = $this->create($password);

        if ($hash === $result) {
            return true;
        }

        return false;
    }

    public function create($password): string
    {
        return md5($password);
    }
}
