<?php

declare(strict_types=1);

namespace Common\View;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Stdlib\AbstractOptions;
use Laminas\Stdlib\Exception\InvalidArgumentException;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\HelperPluginManager;

class OptionsHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var AbstractOptions
     */
    protected $options;

    public function __invoke(string $options)
    {
        $sl = $this->getPluginManager();

        if ($sl->has($options)) {
            $this->setOptions($sl->get($options));
        } else {
            throw new InvalidArgumentException(printf('No option class found using name %s', $options));
        }

        return $this;
    }

    public function get(string $option)
    {
        if (isset($this->getOptions()->$option)) {
            return $this->getOptions()->$option;
        } else {
            throw new InvalidArgumentException(printf('No option called "%s" in class %s', $option, get_class($this->getOptions())));
        }
    }

    /**
     * @return AbstractOptions
     */
    public function getOptions(): AbstractOptions
    {
        return $this->options;
    }

    /**
     * @param AbstractOptions $options
     * @return OptionsHelper
     */
    public function setOptions(AbstractOptions $options): OptionsHelper
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return HelperPluginManager
     */
    public function getPluginManager(): HelperPluginManager
    {
        return $this->getServiceLocator()->getServiceLocator();
    }
}
