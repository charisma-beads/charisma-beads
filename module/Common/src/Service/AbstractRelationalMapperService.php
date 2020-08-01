<?php

namespace Common\Service;

use Common\Model\Model;
use Laminas\Db\ResultSet\HydratingResultSet;


abstract class AbstractRelationalMapperService extends AbstractMapperService
{
    /**
     * @var array
     */
    protected $referenceMap = [];

    /**
     * @var bool
     */
    protected $populate = true;

    /**
     * @param bool $bool
     * @return $this
     */
    public function setPopulate($bool)
    {
        $this->populate = (bool) $bool;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPopulate()
    {
        return $this->populate;
    }

    /**
     * @param array $post
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function search(array $post)
    {
        $models = parent::search($post);

        if ($this->isPopulate()) {
            /** @var Model $model */
            foreach ($models as $model) {
                $this->populate($model, true);
            }
        }

        return $models;
    }

    /**
     * populate relational records.
     *
     * @param \Common\Model\Model $model
     * @param bool|array $children
     * @return \Common\Model\Model
     */
    public function populate($model, $children)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : [];

        foreach ($this->getReferenceMap() as $name => $options) {
            if ($allChildren || in_array($name, $children)) {

                $service        = $this->getRelatedService($name);
                $getIdMethod    = 'get' . ucfirst($options['refCol']);
                $setMethod      = $options['setMethod'] ?? 'set' . ucfirst($name);
                $getMethod      = $options['getMethod'] ?? 'getById';
                $childModel     = $service->$getMethod($model->$getIdMethod(), $options['refCol']);

                if ($childModel instanceof HydratingResultSet) {
                    $childModelObjects = [];

                    foreach ($childModel as $row) {
                        $childModelObjects[] = $row;
                    }

                    $childModel = $childModelObjects;
                }

                $model->$setMethod($childModel);
            }
        }

        return $model;
    }

    /**
     * @param string $name
     * @return AbstractService
     * @throws ServiceException
     */
    public function getRelatedService($name)
    {
        $map = $this->getReferenceMap();

        if (!array_key_exists($name, $map)) {
            throw new ServiceException($name . ' is not related service');
        }

        return $this->getService($map[$name]['service']);
    }

    /**
     * @return array
     */
    public function getReferenceMap()
    {
        return $this->referenceMap;
    }

    /**
     * @param string|array $referenceMap
     * @return $this
     */
    public function setReferenceMap($referenceMap)
    {
        $this->referenceMap = (array)$referenceMap;
        return $this;
    }
}
