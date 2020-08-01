<?php

declare(strict_types=1);

namespace User\View;

use Common\View\AbstractViewHelper;
use User\Controller\Plugin\IsAllowed as PluginIsAllowed;
use User\Model\UserModel;
use User\Service\Acl;

class IsAllowed extends AbstractViewHelper
{
    /**
     * @var PluginIsAllowed
     */
    protected $pluginIsAllowed;

    public function __invoke(?string $resource, ?string $privilege): bool
    {
        return $this->isAllowed($resource, $privilege);
    }

    private function isAllowed(?string $resource, ?string $privilege): bool
    {
        $acl = $this->getPluginIsAllowed();
        return $acl->isAllowed($resource, $privilege);
    }

    private function setPluginIsAllowed(PluginIsAllowed $pluginIsAllowed): IsAllowed
    {
        $this->pluginIsAllowed = $pluginIsAllowed;
        return $this;
    }

    private function getPluginIsAllowed(): PluginIsAllowed
    {
        if (!$this->pluginIsAllowed instanceof PluginIsAllowed) {
            /* @var $acl Acl */
            $acl = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(Acl::class);
            /* @var $identity UserModel|null */
            $identity = $this->getView()->plugin('identity')();

            $pluginIsAllowed = new PluginIsAllowed();
            $pluginIsAllowed->setAcl($acl);
            $pluginIsAllowed->setIdentity($identity);
            $this->setPluginIsAllowed($pluginIsAllowed);
        }

        return $this->pluginIsAllowed;
    }
}
