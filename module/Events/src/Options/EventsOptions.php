<?php

namespace Events\Options;

use Laminas\Stdlib\AbstractOptions;


class EventsOptions extends AbstractOptions
{
    const DATE_DEFAULT  = 'd/m/Y H:i A';

    /**
     * @var string
     */
    protected $dateFormat = self::DATE_DEFAULT;

    /**
     * @var string
     */
    protected $sortOrder = '-dateTime';

    /**
     * @var bool
     */
    protected $showExpiredEvents = false;

    /**
     * @var int
     */
    protected $numberOfEventsToShow = 10;

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     * @return $this
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowExpiredEvents()
    {
        return $this->showExpiredEvents;
    }

    /**
     * @param boolean $showExpiredEvents
     * @return $this
     */
    public function setShowExpiredEvents($showExpiredEvents)
    {
        $this->showExpiredEvents = $showExpiredEvents;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfEventsToShow()
    {
        return $this->numberOfEventsToShow;
    }

    /**
     * @param int $numberOfEventsToShow
     * @return $this
     */
    public function setNumberOfEventsToShow($numberOfEventsToShow)
    {
        $this->numberOfEventsToShow = $numberOfEventsToShow;
        return $this;
    }
}
