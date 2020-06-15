<?php

namespace Contact\Options;

use Zend\Stdlib\AbstractOptions;


class GoogleMapOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $latitude;

    /**
     * @var string
     */
    protected $longitude;

    /**
     * @var int
     */
    protected $zoom = 18;

    /**
     * @var string
     */
    protected $color = 'color';

    /**
     * @var bool
     */
    protected $showMap = true;

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return int
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * @param int $zoom
     * @return $this
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowMap()
    {
        return $this->showMap;
    }

    /**
     * @param boolean $showMap
     * @return $this
     */
    public function setShowMap($showMap)
    {
        $this->showMap = $showMap;
        return $this;
    }
}
