<?php declare(strict_types=1);

namespace Admin\Service;


use Laminas\Navigation\Service\AbstractNavigationFactory;

class AdminUserNavigationFactory extends AbstractNavigationFactory
{
    protected function getName(): string
    {
        return 'admin-user';
    }
}
