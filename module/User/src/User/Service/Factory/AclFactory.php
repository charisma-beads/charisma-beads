<?php

declare(strict_types=1);

namespace User\Service\Factory;

use User\Options\UserOptions;
use User\Service\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm): Acl
    {
        $config     = $sm->get('config');
        $config     = $config['user'];
        /* @var $options UserOptions */
        $options    = $sm->get(UserOptions::class);

        $aclRules = (array_key_exists('acl', $config)) ? $config['acl'] : [];

        $acl = new Acl($aclRules, $options);

        return $acl;
    }
}
