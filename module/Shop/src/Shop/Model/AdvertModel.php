<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use Common\Model\ModelInterface;
use Common\Model\Model;

/**
 * Class Advert
 *
 * @package Shop\Model
 */
class AdvertModel implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $advertId;
    
    /**
     * @var string
     */
    protected $advert;
    
    /**
     * @var bool
     */
    protected $enabled;
 
    /**
     * @return int $advertId
     */
    public function getAdvertId()
    {
        return $this->advertId;
    }

     /**
     * @param int $advertId
     * @return $this
     */
    public function setAdvertId($advertId)
    {
        $this->advertId = $advertId;
        return $this;
    }

    /**
     * @return string $advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * @param string $advert
     * @return $this
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return bool $enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

}
