<?php

namespace Common\Hydrator;

use Common\Model\ModelInterface;
use Laminas\Hydrator\AbstractHydrator as ZendAbstractHydrator;
use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;


class BaseHydrator extends ZendAbstractHydrator
{

    /**
     * Array map of object to database names
     *
     * <database_key> => <object_property>
     *
     * @var array
     */
    protected $map = [];

    /**
     * @var string
     */
    protected $tablePrefix;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setNamingStrategy(new MapNamingStrategy($this->map));
        $this->init();
    }

    /**
     * Method to use to add hydrator setup
     */
    public function init()
    {}

    /**
     * Extract values from an object
     *
     * @param  ModelInterface $object
     * @return array
     */
    public function extract($object)
    {
        $data = $object->getArrayCopy();
        $extractedData = [];

        foreach ($data as $key => $value) {
            $extractName = $this->extractName($key);

            if (array_key_exists($extractName, $this->map)) {
                $value = $this->extractValue($key, $value, $data);
                $extractedData[$extractName] = $value;
            }
        }

        return $extractedData;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  ModelInterface $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        foreach ($data as $key => $value) {

            $hydrateName = $this->hydrateName($key);

            if ($object->has($hydrateName)) {
                $method = 'set' . ucfirst($hydrateName);
                $value = $this->hydrateValue($hydrateName, $value, $data);
                $object->$method($value);
            }
        }

        return $object;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param array $map
     * @return $this
     */
    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }

    /**
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }

    /**
     * @param string $tablePrefix
     * @return $this
     */
    public function setTablePrefix($tablePrefix)
    {
        $this->tablePrefix = $tablePrefix . '.';
        return $this;
    }
}
