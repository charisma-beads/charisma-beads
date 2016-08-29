<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class LatestProductOptions
 *
 * @package Shop\Options
 */
class NewProductsCarouselOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $totalItems;

    /**
     * @var int
     */
    protected $numberItemsToDisplay;

    /**
     * @var bool
     */
    protected $autoPlay;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @param int $totalItems
     * @return $this
     */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = (int) $totalItems;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberItemsToDisplay()
    {
        return $this->numberItemsToDisplay;
    }

    /**
     * @param int $numberItemsToDisplay
     * @return $this
     */
    public function setNumberItemsToDisplay($numberItemsToDisplay)
    {
        $this->numberItemsToDisplay = (int) $numberItemsToDisplay;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoPlay()
    {
        return $this->autoPlay;
    }

    /**
     * @return bool
     */
    public function getAutoPlay()
    {
        return $this->isAutoPlay();
    }

    /**
     * @param boolean $autoPlay
     * @return $this
     */
    public function setAutoPlay($autoPlay)
    {
        $this->autoPlay = (bool) $autoPlay;
        return $this;
    }
}
