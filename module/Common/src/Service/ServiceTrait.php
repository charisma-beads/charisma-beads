<?php

namespace Common\Service;

/**
 * Class ServiceTrait
 *
 * @package Common\Service
 * @method ServiceManager getServiceLocator()
 */
trait ServiceTrait
{
    /**
     * @var string
     */
    protected $serviceName;

    /**
     * @var array
     */
    protected $service = [];

    /**
     * @return string
     */
    protected function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     * @return $this
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    /**
     * @param null $service
     * @param array $options
     * @return object|AbstractService
     */
    protected function getService($service = null, $options = [])
    {
        $service = $service ?? $this->getServiceName();

        if (!isset($this->service[$service])) {
            $sl = $this->getServiceLocator()->get(ServiceManager::class);
            $this->service[$service] = $sl->get($service, $options);
        }

        return $this->service[$service];
    }
}
