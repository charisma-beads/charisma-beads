<?php declare(strict_types=1);

namespace Admin\Service;


use Zend\Navigation\Service\AbstractNavigationFactory;

class AdminUserNavigationFactory extends AbstractNavigationFactory
{
    protected function getName(): string
    {
        return 'admin-user';
    }
}
