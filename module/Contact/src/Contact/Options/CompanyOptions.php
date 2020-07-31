<?php

namespace Contact\Options;

use Common\Model\AbstractCollection;
use Common\Model\ModelInterface;
use Contact\Model\AddressLinesCollection;
use Laminas\Stdlib\AbstractOptions;
use Laminas\Stdlib\Exception\InvalidArgumentException;


class CompanyOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var AddressLinesCollection
     */
    protected $address;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return AddressLinesCollection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $addressLines
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setAddress($addressLines)
    {
        if (is_array($addressLines)) {
            $addressLines = new AddressLinesCollection($addressLines);
        }

        if (!$addressLines instanceof AddressLinesCollection) {
            throw new InvalidArgumentException(
                'you must only use an array or an instance of Contact\Model\AddressLinesCollection'
            );
        }

        $this->address = $addressLines;

        return $this;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $returnArray = [];

        foreach ($array as $key => $value) {

            if ($value instanceof AbstractCollection) {
                $entities = $value->getEntities();
                foreach ($entities as $item => $model) {
                    if ($model instanceof ModelInterface) {
                        $returnArray[$key][$item] = $model->getArrayCopy();
                    }
                }
            } else {
                $returnArray[$key] = $value;
            }
        }

        return $returnArray;
    }
}
