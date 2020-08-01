<?php

namespace Shop\Model;

use Common\Model\AbstractCollection;

/**
 * Class CategoryCollection
 *
 * @package Shop\Model
 */
class ProductCategoryCollection extends AbstractCollection
{
    protected $entityClass = VoucherProductCategoryModel::class;

    /**
     * @param $array
     * @throws \Common\Model\CollectionException
     */
    public function fromArray($array)
    {
        foreach ($array as $value) {
            /* @var $entity VoucherProductCategoryModel */
            $entity = new $this->entityClass();

            $entity->setCategoryId($value);
            $this->add($entity);

        }
    }

    public function toArray()
    {
        $returnArray = [];

        /* @var $value VoucherProductCategoryModel */
        foreach ($this->getEntities() as $value) {
            $returnArray[] = $value->getCategoryId();
        }

        return $returnArray;
    }
}
