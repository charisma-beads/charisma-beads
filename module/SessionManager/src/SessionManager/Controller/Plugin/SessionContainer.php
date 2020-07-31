<?php

namespace SessionManager\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use SessionManager\SessionContainerTrait;
use Laminas\Session\Container;

class SessionContainer extends AbstractPlugin
{
    use SessionContainerTrait;

    /**
     * @param string $ns
     * @return Container
     */
    public function __invoke($ns = null)
    {
        if (is_string($ns)) {
            $this->setNs($ns);
        }

        return $this->getSessionContainer();
    }
}
