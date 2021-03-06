<?php

namespace Common\View;

use Laminas\View\Helper\AbstractHelper;

class FormatDate extends AbstractHelper
{
    /**
     * @var string
     */
    protected $format = 'd/m/Y H:i:s';

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @param null $date
     * @param null $format
     * @return $this
     */
    public function __invoke($date = null, $format = null)
    {
        $this->setDate($date);

        if ($format) {
            $this->setFormat($format);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        if (!$this->date instanceof \DateTime) {
            return '';
        }
        return $this->getDate()->format($this->getFormat());
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setDate($date)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        if (is_int($date)) {
            $timestamp = $date;
            $date = new \DateTime();
            $date->setTimestamp($timestamp);
        }

        $this->date = $date;
        return $this;
    }

}
