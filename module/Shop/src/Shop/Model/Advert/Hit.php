<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Advert;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\DateCreatedTrait;

/**
 * Class Hit
 *
 * @package Shop\Model\Advert
 */
class Hit implements ModelInterface
{
    use Model,
        DateCreatedTrait;
    
    /**
     * @var int
     */
    protected $advertHitId;
    
    /**
     * @var int
     */
    protected $advertId;
 
    /**
     * @return int $advertHitId
     */
    public function getAdvertHitId()
    {
        return $this->advertHitId;
    }

    /**
     * @param int $advertHitId
     * @return $this
     */
    public function setAdvertHitId($advertHitId)
    {
        $this->advertHitId = $advertHitId;
        return $this;
    }

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
}
