<?php

namespace FileManager\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;


class FileModel implements ModelInterface
{
    use Model;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $size;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $tempName;

    /**
     * @var int
     */
    protected $error;

    /**
     * @return string
     */
    function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $fileName
     * @return $this
     */
    function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return string
     */
    function getSize()
    {
        return $this->size;
    }

    /**
     * @param $size
     * @return $this
     */
    function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    function getTempName()
    {
        return $this->tempName;
    }

    /**
     * @param $tempName
     * @return $this
     */
    function setTempName($tempName)
    {
        $this->tempName = $tempName;
        return $this;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param int $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
} 