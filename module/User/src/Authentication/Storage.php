<?php

declare(strict_types=1);

namespace User\Authentication;

use Laminas\Authentication\Storage\Session;

class Storage extends Session
{
    public function rememberMe(int $rememberMe = 0, int $time = 1209600): void
    {
        if ($rememberMe == 1) {
            ini_set('session.gc_maxlifetime', (string) $time);

            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe(): void
    {
        $this->session->getManager()->forgetMe();
    }
}