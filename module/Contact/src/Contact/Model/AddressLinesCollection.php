<?php

namespace Contact\Model;

use Common\Model\AbstractCollection;


class AddressLinesCollection extends AbstractCollection
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
        $this->addAddressLines($array);
    }

    /**
     * @param array $addressLines
     */
    public function addAddressLines(array $addressLines)
    {
        foreach ($addressLines as $line) {
            $this->addAddressLine($line);
        }
    }

    /**
     * @param array|AbstractLine $addressLine
     * @return AddressLinesCollection
     */
    public function addAddressLine($addressLine): AddressLinesCollection
    {
        if ($addressLine instanceof AbstractLine) {
            $this->add($addressLine);
        }

        if (is_array($addressLine)) {
            $addressLine = new $this->entityClass($addressLine);
            $this->add($addressLine);
        }

        return $this;
    }
}
