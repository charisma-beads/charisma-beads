<?php

namespace SessionManager;

use Zend\Session\Container;

/**
 * Class SessionContainerTrait
 *
 * @package UthandoSessionManager
 */
trait SessionContainerTrait
{
    /**
     * @var Container
     */
    protected $sessionContainer;

    /**
     * @var string
     */
    protected $ns = __CLASS__;

    /**
     * @return Container
     */
    public function getSessionContainer()
    {
        if (!$this->sessionContainer instanceof Container) {
            $this->setSessionContainer(new Container($this->getNs()));
        }

        return $this->sessionContainer;
    }

    /**
     * @param Container $ns
     */
    public function setSessionContainer(Container $ns)
    {
        $this->sessionContainer = $ns;
    }

    /**
     * @return string $ns
     */
    public function getNs()
    {
        return $this->ns;
    }

    /**
     * @param $ns
     * @return $this
     */
    public function setNs($ns)
    {
        $this->ns = $ns;
        return $this;
    }

}
