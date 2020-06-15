<?php

declare(strict_types=1);

namespace User\Service;

use Zend\Permissions\Acl\AclInterface;

/**
 * Interface AclAwareInterface
 *
 * @package UthandoUser\Service
 */
interface AclAwareInterface
{
    public function setAcl(AclInterface $acl = null);

    public function getAcl();

    //public function setRole($role = null);
    //public function getRole();
}
