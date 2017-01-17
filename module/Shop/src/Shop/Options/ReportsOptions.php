<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Options;


use Zend\Stdlib\AbstractOptions;

class ReportsOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $memoryLimit;

    /**
     * @var string
     */
    protected $monthFormat;

    /**
     * @var string
     */
    protected $writerType;

    /**
     * @return string
     */
    public function getMemoryLimit()
    {
        return $this->memoryLimit;
    }

    /**
     * @param string $memoryLimit
     * @return $this
     */
    public function setMemoryLimit($memoryLimit)
    {
        $this->memoryLimit = $memoryLimit;
        return $this;
    }

    /**
     * @return string
     */
    public function getMonthFormat()
    {
        return $this->monthFormat;
    }

    /**
     * @param string $monthFormat
     * @return $this
     */
    public function setMonthFormat($monthFormat)
    {
        $this->monthFormat = $monthFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getWriterType()
    {
        return $this->writerType;
    }

    /**
     * @param string $writerType
     * @return $this
     */
    public function setWriterType($writerType)
    {
        $this->writerType = $writerType;
        return $this;
    }
}