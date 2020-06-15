<?php

namespace Contact\Model;

use Common\Model\AbstractCollection;

/**
 * Class TransportListCollection
 *
 * @package Contact\Model
 * @method AbstractLine offsetGet($key)
 */
class TransportListCollection extends AbstractCollection
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
        $this->addTransportLines($array);
    }

    /**
     * @param array $transportLines
     */
    public function addTransportLines(array $transportLines)
    {
        foreach ($transportLines as $line) {
            $this->addTransportLine($line);
        }
    }

    /**
     * @param AbstractLine|array $transportLine
     * @return TransportListCollection
     */
    public function addTransportLine($transportLine): TransportListCollection
    {
        if ($transportLine instanceof AbstractLine) {
            $this->add($transportLine);
        }

        if (is_array($transportLine)) {
            $transportLine = new $this->entityClass($transportLine);
            $this->add($transportLine);
        }

        return $this;
    }
}
