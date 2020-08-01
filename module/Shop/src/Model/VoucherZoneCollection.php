<?php

namespace Shop\Model;

use Common\Model\AbstractCollection;

/**
 * Class VoucherZoneCollection
 *
 * @package Shop\Model
 */
class VoucherZoneCollection extends AbstractCollection
{
    protected $entityClass = VoucherZoneModel::class;

    /**
     * @param $array
     * @throws \Common\Model\CollectionException
     */
    public function fromArray($array)
    {
        foreach ($array as $value) {
            /* @var $entity VoucherZoneModel */
            $entity = new $this->entityClass();
            $entity->setZoneId($value);
            $this->add($entity);
        }
    }

    public function toArray()
    {
        $returnArray = [];

        /* @var $value VoucherZoneModel */
        foreach ($this->getEntities() as $value) {
            $returnArray[] = $value->getZoneId();
        }

        return $returnArray;
    }
}
