<?php

declare(strict_types=1);

namespace User\Service\Factory;

use Zend\Navigation\Service\AbstractNavigationFactory;

class UserNavigationFactory extends AbstractNavigationFactory
{
    protected function getName(): string
    {
        return 'user';
    }
}
