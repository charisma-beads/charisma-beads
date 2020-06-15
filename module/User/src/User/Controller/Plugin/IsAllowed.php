<?php

declare(strict_types=1);

namespace User\Controller\Plugin;

use User\Model\UserModel;
use User\Service\Acl;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Role\RoleInterface;

class IsAllowed extends AbstractPlugin
{
    /**
     * @var Acl
     */
    protected $acl;

    /**
     * @var RoleInterface
     */
    protected $identity;

    public function __invoke(?string $resource, ?string $privilege): bool
    {
        return $this->isAllowed($resource, $privilege);
    }

    public function isAllowed(?string $resource, ?string $privilege): bool
    {
        if (null === $this->acl) {
            $this->getAcl();
        }

        return $this->acl->isAllowed($this->getIdentity()->getRoleId(), $resource, $privilege);
    }

    public function setAcl(Acl $acl): IsAllowed
    {
        $this->acl = $acl;
        return $this;
    }

    public function getAcl(): Acl
    {
        if (!$this->acl) {
            /* @var $acl Acl */
            $acl = $this->getController()
                ->getServiceLocator()
                ->get(Acl::class);

            $this->setAcl($acl);
        }

        return $this->acl;
    }

    public function getIdentity(): ?RoleInterface
    {
        if (null === $this->identity) {
            $identity = $this->getController()->plugin('identity');
            $this->setIdentity($identity());
        }

        return $this->identity;
    }

    public function setIdentity(?UserModel $identity): IsAllowed
    {
        if ($identity instanceof UserModel) {
            $this->identity = $identity;
        } else {
            $this->identity = new Role('guest');
        }

        return $this;
    }
}
