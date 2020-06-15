<?php

declare(strict_types=1);

namespace User\Hydrator;

use Common\Hydrator\BaseHydrator;

class LimitLoginHydrator extends BaseHydrator
{
    protected $map = [
        'id'            => 'id',
        'ip'            => 'ip',
        'attempts'      => 'attempts',
        'attempt_time'  => 'attemptTime',
        'locked_time'   => 'lockedTime',
    ];
}
