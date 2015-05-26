<?php
namespace Shop\Model\Advert;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;

class Advert implements ModelInterface
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
