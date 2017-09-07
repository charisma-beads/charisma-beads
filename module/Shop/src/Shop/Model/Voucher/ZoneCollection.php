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
 * Class ZoneCollection
 *
 * @package Shop\Model\Voucher
 */
class ZoneCollection extends AbstractCollection
{
    protected $entityClass = Zone::class;

    /**
     * @param $array
     */
    public function fromArray($array)
    {
        foreach ($array as $value) {
            /* @var $entity Zone */
            $entity = new $this->entityClass();
            $entity->setZoneId($value);
            $this->add($entity);
        }
    }

    public function toArray()
    {
        $returnArray = [];

        /* @var $value Zone */
        foreach ($this->getEntities() as $value) {
            $returnArray[] = $value->getZoneId();
        }

        return $returnArray;
    }
}