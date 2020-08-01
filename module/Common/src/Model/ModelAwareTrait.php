<?php

namespace Common\Model;

use Laminas\Hydrator\HydratorAwareTrait;
use Laminas\Hydrator\HydratorInterface;


trait ModelAwareTrait
{
    use HydratorAwareTrait;

    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @param null $data
     * @return object|ModelInterface
     */
    public function getModel($data = null)
    {
        $model = clone $this->model;

        if ($data) {
            $hydrator = $this->getHydrator();
            $data = (array) $data;

            return $hydrator->hydrate($data, $model);
        }

        return $model;
    }

    /**
     * @param ModelInterface $model
     * @return $this
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array|ModelInterface $dataOrModel
     * @param HydratorInterface $hydrator
     * @return array
     */
    public function extract($dataOrModel, HydratorInterface $hydrator = null)
    {
        if (is_array($dataOrModel)) {
            return $dataOrModel;
        }

        if (!$dataOrModel instanceOf ModelInterface) {
            throw new \InvalidArgumentException('Model object needs to implement ModelInterface  got: ' . getType
                ($dataOrModel));
        }

        $hydrator = $hydrator ?: $this->getHydrator();

        return $hydrator->extract($dataOrModel);
    }
}
