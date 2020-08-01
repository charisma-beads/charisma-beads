<?php

namespace Contact\Model;

use Common\Model\AbstractCollection;

/**
 * Class BusinessHoursCollection
 *
 * @package Contact\Model
 * @method AbstractLine offsetGet($key)
 */
class BusinessHoursCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $entityClass = AbstractLine::class;

    /**
     * @param array $array
     */
    public function __construct($array = [])
    {
        $this->addBusinessHours($array);
    }

    /**
     * @param array $businessHours
     */
    public function addBusinessHours(array $businessHours)
    {
        foreach ($businessHours as $line) {
            $this->addBusinessHourLine($line);
        }
    }

    /**
     * @param AbstractLine|array $hourLine
     * @return BusinessHoursCollection
     */
    public function addBusinessHourLine($hourLine): BusinessHoursCollection
    {
        if ($hourLine instanceof AbstractLine) {
            $this->add($hourLine);
        }

        if (is_array($hourLine)) {
            $hourLine = new $this->entityClass($hourLine);
            $this->add($hourLine);
        }

        return $this;
    }
}
