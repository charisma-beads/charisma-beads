<?php

namespace SessionManager\Model;

use Common\Model\ModelInterface;
use Common\Model\Model;

class SessionModel implements ModelInterface
{
    use Model;

    /**
     * ID Column
     * @var string
     */
    protected $id;

    /**
     * Name Column
     * @var string
     */
    protected $name;

    /**
     * Modified Column
     * @var int
     */
    protected $modified;

    /**
     * Lifetime Column
     * @var int
     */
    protected $lifetime;

    /**
     * Data Column
     * @var string
     */
    protected $data;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;
        return $this;
    }

    /**
     * @return int
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param $modified
     * @return $this
     */
    public function setModified($modified)
    {
        $this->modified = (int)$modified;
        return $this;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param $lifetime
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = (int)$lifetime;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = (string)$data;
        return $this;
    }
}
