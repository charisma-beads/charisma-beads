<?php

declare(strict_types=1);

namespace User\Form\Element;

use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

abstract class AbstractResourceList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $emptyOption = 'None';

    /**
     * @return void
     */
    public function init(): void
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');

        $resources = $config['user']['acl']['resources'];

        $regex = '/^' . $this->resource . ':/';

        $resources = preg_grep($regex, $resources);

        $this->setValueOptions($this->getResources($resources));
    }

    public function getResources(array $resources): array
    {
        $routeArray = [];

        foreach ($resources as $val) {
            $routeArray[$val] = $val;
        }

        return $routeArray;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): AbstractResourceList
    {
        $this->resource = $resource;
        return $this;
    }
}
