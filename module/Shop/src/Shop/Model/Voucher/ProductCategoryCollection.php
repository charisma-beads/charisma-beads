<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Model\Voucher;

use UthandoCommon\Model\AbstractCollection;

/**
 * Class CategoryCollection
 *
 * @package Shop\Model\Voucher
 */
class ProductCategoryCollection extends AbstractCollection
{
    protected $entityClass = ProductCategory::class;

    /**
     * @param $array
     */
    public function fromArray($array)
    {
        foreach ($array as $value) {
            /* @var $entity ProductCategory */
            $entity = new $this->entityClass();

            $entity->setCategoryId($value);
            $this->add($entity);

        }
    }

    public function toArray()
    {
        $returnArray = [];

        /* @var $value ProductCategory */
        foreach ($this->getEntities() as $value) {
            $returnArray[] = $value->getCategoryId();
        }

        return $returnArray;
    }
}
