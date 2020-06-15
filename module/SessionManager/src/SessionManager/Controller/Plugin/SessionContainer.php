<?php

namespace SessionManager\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use SessionManager\SessionContainerTrait;
use Zend\Session\Container;

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
